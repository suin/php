<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\DevTools;

use Google_Service_Gmail;
use Google_Service_Gmail_MessagePartHeader;
use Suin\Jnb\GmailToSlack\DefaultEmailProcessors;
use Suin\Jnb\GmailToSlack\DefaultGoogleClient;
use Suin\Jnb\GmailToSlack\Email;
use Suin\Jnb\GmailToSlack\Logger\StderrLogger;
use Suin\Jnb\GmailToSlack\ProcessedLabelAdderInterface;
use Suin\Jnb\GmailToSlack\Slack\SlackNotifier;

final class TestSlackNotification implements ProcessedLabelAdderInterface
{
    public function testSlackNotification(
        string $email,
        string $slackWebhookEndpoint,
        string $messageId
    ): void {
        $client = DefaultGoogleClient::create();
        $client->setSubject($email);
        $logger = new StderrLogger();
        $slackNotifier = new SlackNotifier($slackWebhookEndpoint);
        $processors = DefaultEmailProcessors::create($logger, $slackNotifier);
        $gmail = new Google_Service_Gmail($client);

        $message = $gmail->users_messages->get($email, $messageId);
        $payload = $message->getPayload();
        $processors->process(
            new Email(
                $message->getId(),
                $this->getSubject((array) $payload->getHeaders()),
                $this->getBody($payload->getBody()->data),
                $this
            )
        );
    }

    public function addLabel(string $messageId): void
    {
        // nothing to do
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
