<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack;

use Google_Client;
use Google_Service_Gmail;
use Suin\Jnb\GmailToSlack\Logger\StderrLogger;
use Suin\Jnb\GmailToSlack\Slack\SlackNotifier;
use Suin\Jnb\GmailToSlack\VisaRefundEmail\VisaRefundEmailProcessor;
use Suin\Jnb\GmailToSlack\VisaWithdrawalEmail\VisaWithdrawalEmailProcessor;

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
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Google_Service_Gmail::GMAIL_MODIFY);
        $client->setApplicationName('JapannetbankGmailToSlack');

        $logger = new StderrLogger();
        $gmail = new Gmail($client, $logger);
        $slackNotifier = new SlackNotifier($this->slackWebhookEndpoint);
        $processors = new EmailProcessors(
            new VisaWithdrawalEmailProcessor($logger, $slackNotifier),
            new VisaRefundEmailProcessor($logger, $slackNotifier)
        );

        foreach ($gmail->fetchEmails($this->gmailAccount) as $email) {
            $processors->process($email);
            $email->markProcessed();
        }
    }
}
