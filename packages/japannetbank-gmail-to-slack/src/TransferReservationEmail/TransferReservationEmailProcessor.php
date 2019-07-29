<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\TransferReservationEmail;

use Suin\Jnb\GmailToSlack\Email;
use Suin\Jnb\GmailToSlack\EmailProcessor;
use Suin\Jnb\GmailToSlack\Logger\ExceptionLogger;

final class TransferReservationEmailProcessor implements EmailProcessor
{
    /**
     * @var TransferReservationEmailHandler[]
     */
    private $handlers = [];

    /**
     * @var ExceptionLogger
     */
    private $exceptionLogger;

    public function __construct(
        ExceptionLogger $logger,
        TransferReservationEmailHandler ...$handlers
    ) {
        $this->exceptionLogger = $logger;
        $this->handlers = $handlers;
    }

    public function canProcess(Email $email): bool
    {
        return \strpos($email->subject(), '振込予約のご確認') !== false;
    }

    public function process(Email $email): void
    {
        if ($this->canProcess($email)) {
            try {
                $withdrawalEmail = new TransferReservationEmail($email->body());
            } catch (TransferReservationEmailParseException $exception) {
                $this->exceptionLogger->logException($exception);
                return;
            }

            foreach ($this->handlers as $handler) {
                $handler->handleTransferReservationEmail($withdrawalEmail);
            }
        }
    }
}
