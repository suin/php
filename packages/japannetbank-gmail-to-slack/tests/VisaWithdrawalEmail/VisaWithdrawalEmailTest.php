<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\VisaWithdrawalEmail;

use PHPUnit\Framework\TestCase;

final class VisaWithdrawalEmailTest extends TestCase
{
    public function test_parse_email_body(): void
    {
        $email = new VisaWithdrawalEmail(
            \file_get_contents(__DIR__ . '/VisaWithdrawalEmailBody.txt')
        );
        self::assertSame(
            [
                $email->dateOfWithdrawal()->format('Y-m-d H:i:s'),
                $email->amount(),
                $email->shopName(),
                $email->transactionId(),
            ],
            [
                '2018-07-23 07:43:23',
                1618,
                'ＡＭＡＺＯＮ　ＣＯ　ＪＰ',
                '1A204001',
            ]
        );
    }
}
