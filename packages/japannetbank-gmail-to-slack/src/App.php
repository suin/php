<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack;

use Suin\Jnb\GmailToSlack\Logger\StderrLogger;
use Suin\Jnb\GmailToSlack\Slack\SlackNotifier;

final class App
{
    /**
     * @var string
     */
    private $gmailAccount;

    /**
     * @var string
     */
    private $slackWebhookEndpoint;

    public function __construct(
        string $gmailAccount,
        string $slackWebhookEndpoint
    ) {
        $this->slackWebhookEndpoint = $slackWebhookEndpoint;
        $this->gmailAccount = $gmailAccount;
    }

    public function run(): void
    {
        $client = DefaultGoogleClient::create();
        $logger = new StderrLogger();
        $gmail = new Gmail($client, $logger);
        $slackNotifier = new SlackNotifier($this->slackWebhookEndpoint);
        $processors = DefaultEmailProcessors::create($logger, $slackNotifier);

        foreach ($gmail->fetchEmails($this->gmailAccount) as $email) {
            $processors->process($email);
            $email->markProcessed();
        }
    }
}
