<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack;

interface EmailProcessor
{
    public function canProcess(Email $email): bool;

    public function process(Email $email): void;
}
