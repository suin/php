<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\VisaRefundEmail;

interface VisaRefundEmailHandler
{
    public function handleVisaRefundEmail(VisaRefundEmail $email): void;
}
