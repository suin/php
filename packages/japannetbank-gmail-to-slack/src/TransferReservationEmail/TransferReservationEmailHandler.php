<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\TransferReservationEmail;

interface TransferReservationEmailHandler
{
    public function handleTransferReservationEmail(
        TransferReservationEmail $email
    ): void;
}
