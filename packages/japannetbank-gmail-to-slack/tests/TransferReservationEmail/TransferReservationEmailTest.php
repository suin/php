<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\TransferReservationEmail;

use PHPUnit\Framework\TestCase;

final class TransferReservationEmailTest extends TestCase
{
    public function test_parse_email_body(): void
    {
        $email = new TransferReservationEmail(
            \file_get_contents(__DIR__ . '/TransferReservationEmailBody.txt')
        );
        self::assertSame(
            [
                $email->transferredOn()->format('Y-m-d'),
                $email->receptionNumber(),
                $email->payeeName(),
                $email->amount(),
            ],
            [
                '2019-07-31',
                '201907290085756',
                'カ）ホゲホゲ．．',
                20000,
            ]
        );
    }
}
