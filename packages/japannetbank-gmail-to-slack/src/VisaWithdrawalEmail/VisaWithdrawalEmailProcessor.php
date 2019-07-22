<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\VisaWithdrawalEmail;

use Suin\Jnb\GmailToSlack\Email;
use Suin\Jnb\GmailToSlack\EmailProcessor;
use Suin\Jnb\GmailToSlack\Logger\ExceptionLogger;

final class VisaWithdrawalEmailProcessor implements EmailProcessor
{
    /**
     * @var VisaWithdrawalEmailHandler[]
     */
    private $handlers = [];

    /**
     * @var ExceptionLogger
     */
    private $exceptionLogger;

    public function __construct(
        ExceptionLogger $logger,
        VisaWithdrawalEmailHandler ...$handlers
    ) {
        $this->exceptionLogger = $logger;
        $this->handlers = $handlers;
    }

    public function canProcess(Email $email): bool
    {
        return \strpos($email->subject(), 'Ｖｉｓａ') !== false
            && \strpos($email->subject(), 'お引き落') !== false;
    }

    public function process(Email $email): void
    {
        if ($this->canProcess($email)) {
            try {
                $withdrawalEmail = new VisaWithdrawalEmail($email->body());
            } catch (VisaWithdrawalEmailParseException $exception) {
                $this->exceptionLogger->logException($exception);
                return;
            }

            foreach ($this->handlers as $handler) {
                $handler->handleVisaWithdrawalEmail($withdrawalEmail);
            }
        }
    }
}
