<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\DevTools;

use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use Suin\Jnb\GmailToSlack\DefaultGoogleClient;

final class DownloadJnbEmails
{
    public function downloadJnbEmails(string $email): void
    {
        $client = DefaultGoogleClient::create();
        $client->setSubject($email);

        $gmail = new Google_Service_Gmail($client);

        /** @var Google_Service_Gmail_Message[] $messages */
        $messages = $gmail->users_messages->listUsersMessages(
            $email,
            ['q' => 'from:(japannetbank.co.jp)']
        );

        foreach ($messages as $message) {
            $messageId = $message->getId();
            $message = $gmail->users_messages->get($email, $messageId);

            $data = '';
            $subject = 'unknown';
            $date = '0000-00-00';

            foreach ($message->getPayload()->getHeaders() as $header) {
                $data .= "{$header->name}: {$header->value}\n";

                if ($header->name === 'Subject') {
                    $subject = $header->value;
                }

                if ($header->name === 'Date') {
                    $date = \date('Y-m-d', \strtotime($header->value));
                }
            }
            $data .= "\n\n";
            $data .= $this->decode(
                $message->getPayload()->getBody()->getData()
            );
            \file_put_contents(
                "./emails/${date}-${subject}-${messageId}.txt",
                $data
            );
        }
    }

    private function decode(string $data): string
    {
        return \base64_decode(
            \str_replace(['-', '_'], ['+', '/'], $data),
            true
        );
    }
}
