<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack;

use Suin\Jnb\GmailToSlack\Logger\ExceptionLogger;
use Suin\Jnb\GmailToSlack\Slack\SlackNotifier;
use Suin\Jnb\GmailToSlack\TransferReservationEmail\TransferReservationEmailProcessor;
use Suin\Jnb\GmailToSlack\VisaRefundEmail\VisaRefundEmailProcessor;
use Suin\Jnb\GmailToSlack\VisaWithdrawalEmail\VisaWithdrawalEmailProcessor;

final class DefaultEmailProcessors
{
    public static function create(
        ExceptionLogger $logger,
        SlackNotifier $slackNotifier
    ): EmailProcessors {
        return new EmailProcessors(
            new VisaWithdrawalEmailProcessor($logger, $slackNotifier),
            new VisaRefundEmailProcessor($logger, $slackNotifier),
            new TransferReservationEmailProcessor($logger, $slackNotifier)
        );
    }
}
