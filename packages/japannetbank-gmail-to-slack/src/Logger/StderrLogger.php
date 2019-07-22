<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\Logger;

use Suin\Jnb\GmailToSlack\EmailParseException;

final class StderrLogger implements ExceptionLogger, DebugLogger
{
    public function logException(\Exception $exception): void
    {
        if ($exception instanceof EmailParseException) {
            $this->log($exception . "\nEmail Body:\n" . $exception->getBody());
        } else {
            $this->log((string) $exception);
        }
    }

    public function debug(string $message): void
    {
        $this->log($message);
    }

    private function log(string $message): void
    {
        \file_put_contents('php://stderr', $message . "\n");
    }
}
