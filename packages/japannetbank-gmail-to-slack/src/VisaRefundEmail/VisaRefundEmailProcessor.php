<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\VisaRefundEmail;

use Suin\Jnb\GmailToSlack\Email;
use Suin\Jnb\GmailToSlack\EmailProcessor;
use Suin\Jnb\GmailToSlack\Logger\ExceptionLogger;

final class VisaRefundEmailProcessor implements EmailProcessor
{
    /**
     * @var VisaRefundEmailHandler[]
     */
    private $handlers = [];

    /**
     * @var ExceptionLogger
     */
    private $exceptionLogger;

    public function __construct(
        ExceptionLogger $logger,
        VisaRefundEmailHandler ...$handlers
    ) {
        $this->exceptionLogger = $logger;
        $this->handlers = $handlers;
    }

    public function canProcess(Email $email): bool
    {
        return \strpos($email->subject(), 'Ｖｉｓａ') !== false
            && \strpos($email->subject(), 'ご返金') !== false;
    }

    public function process(Email $email): void
    {
        if ($this->canProcess($email)) {
            try {
                $withdrawalEmail = new VisaRefundEmail($email->body());
            } catch (VisaRefundEmailParseException $exception) {
                $this->exceptionLogger->logException($exception);
                return;
            }

            foreach ($this->handlers as $handler) {
                $handler->handleVisaRefundEmail($withdrawalEmail);
            }
        }
    }
}
