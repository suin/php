<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\VisaWithdrawalEmail;

interface VisaWithdrawalEmailHandler
{
    public function handleVisaWithdrawalEmail(VisaWithdrawalEmail $email): void;
}
