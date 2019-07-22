<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\Logger;

interface ExceptionLogger
{
    public function logException(\Exception $exception): void;
}
