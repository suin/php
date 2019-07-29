<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\Slack;

use Maknz\Slack\Client;
use Suin\Jnb\GmailToSlack\TransferReservationEmail\TransferReservationEmail;
use Suin\Jnb\GmailToSlack\TransferReservationEmail\TransferReservationEmailHandler;
use Suin\Jnb\GmailToSlack\VisaRefundEmail\VisaRefundEmail;
use Suin\Jnb\GmailToSlack\VisaRefundEmail\VisaRefundEmailHandler;
use Suin\Jnb\GmailToSlack\VisaWithdrawalEmail\VisaWithdrawalEmail;
use Suin\Jnb\GmailToSlack\VisaWithdrawalEmail\VisaWithdrawalEmailHandler;

final class SlackNotifier implements
    VisaWithdrawalEmailHandler,
    VisaRefundEmailHandler,
    TransferReservationEmailHandler
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var VisaWithdrawalMessageMaker
     */
    private $visaWithdrawalMessageMaker;

    /**
     * @var VisaRefundMessageMaker
     */
    private $visaRefundMessageMaker;

    /**
     * @var TransferReservationMessageMaker
     */
    private $transferReservationMessageMaker;

    public function __construct(string $webhookEndpoint)
    {
        $this->client = new Client($webhookEndpoint);
        $this->visaWithdrawalMessageMaker = new VisaWithdrawalMessageMaker();
        $this->visaRefundMessageMaker = new VisaRefundMessageMaker();
        $this->transferReservationMessageMaker
            = new TransferReservationMessageMaker();
    }

    public function handleVisaWithdrawalEmail(VisaWithdrawalEmail $email): void
    {
        $this->sendMessage(
            $this->visaWithdrawalMessageMaker->makeMessage($email)
        );
    }

    public function handleVisaRefundEmail(VisaRefundEmail $email): void
    {
        $this->sendMessage(
            $this->visaRefundMessageMaker->makeMessage($email)
        );
    }

    public function handleTransferReservationEmail(
        TransferReservationEmail $email
    ): void {
        $this->sendMessage(
            $this->transferReservationMessageMaker->makeMessage($email)
        );
    }

    private function sendMessage(SlackMessage $message): void
    {
        $this->client
            ->createMessage()
            ->attach($message->attachment())
            ->send($message->text());
    }
}
