<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack;

interface ProcessedLabelAdderInterface
{
    public function addLabel(string $messageId): void;
}
