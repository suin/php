<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack;

use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Label;
use Google_Service_Gmail_Message;
use Google_Service_Gmail_MessagePartHeader;
use Suin\Jnb\GmailToSlack\Logger\DebugLogger;

final class Gmail
{
    /**
     * @var string
     */
    private $labelName = 'Slack通知済';

    /**
     * @var Google_Service_Gmail
     */
    private $gmail;

    /**
     * @var DebugLogger
     */
    private $logger;

    public function __construct(Google_Client $client, DebugLogger $logger)
    {
        $this->gmail = new Google_Service_Gmail($client);
        $this->logger = $logger;
    }

    /**
     * @return Email[]
     */
    public function fetchEmails(string $email): iterable
    {
        $this->gmail->getClient()->setSubject($email);

        $processedLabelId = $this->fetchProcessedLabelId($email);

        if ($processedLabelId === null) {
            $processedLabelId = $this->createProcessedLabel($email);
        }

        $this->debug(
            "The label ID of '{$this->labelName}' is {$processedLabelId}"
        );

        $query = 'from:(japannetbank.co.jp) -label:' . $this->labelName;
        $this->debug("Querying emails by {$query}");
        /** @var Google_Service_Gmail_Message[] $messages */
        $messages = $this->gmail->users_messages->listUsersMessages(
            $email,
            [
                'q' => 'from:(japannetbank.co.jp) -label:' . $this->labelName,
            ]
        );

        foreach ($messages as $message) {
            $messageId = $message->getId();
            $message = $this->gmail->users_messages->get($email, $messageId);
            $labelIds = $message->getLabelIds();

            if (\in_array($processedLabelId, $labelIds, true)) {
                $this->debug(
                    "Message(${messageId}) has already been processed."
                );
                continue;
            }

            $this->debug("Message(${messageId}) needs to be processed.");
            $payload = $message->getPayload();
            yield new Email(
                $message->getId(),
                $this->getSubject((array) $payload->getHeaders()),
                $this->getBody($payload->getBody()->data),
                new ProcessedLabelAdder($this->gmail, $email, $processedLabelId)
            );
        }
    }

    private function fetchProcessedLabelId(string $userId): ?string
    {
        $this->debug(
            "Fetching the label ID of '{$this->labelName}' for {$userId}"
        );

        /** @var Google_Service_Gmail_Label[] $labels */
        $labels = $this->gmail->users_labels->listUsersLabels($userId);

        foreach ($labels as $label) {
            if ($label->getName() === $this->labelName) {
                return (string) $label->getId();
            }
        }
        return null;
    }

    private function createProcessedLabel(string $userId): string
    {
        $this->debug("Creating label '{$this->labelName}'");
        $label = new Google_Service_Gmail_Label();
        $label->setName($this->labelName);
        return (string) $this->gmail->users_labels->create($userId, $label)
            ->getId();
    }

    private function debug(string $message): void
    {
        $this->logger->debug($message);
    }

    private function getSubject(array $headers): string
    {
        return $this->getHeader('Subject', $headers);
    }

    private function getBody(string $bodyData): string
    {
        $body = \str_replace(['-', '_'], ['+', '/'], $bodyData);
        return \base64_decode($body, true);
    }

    /**
     * @param Google_Service_Gmail_MessagePartHeader[] $headers
     */
    private function getHeader(string $name, array $headers): string
    {
        foreach ($headers as $header) {
            if ($header->name === $name) {
                return $header->value;
            }
        }
        return '';
    }
}
