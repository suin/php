<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\Logger;

interface DebugLogger
{
    public function debug(string $message): void;
}
