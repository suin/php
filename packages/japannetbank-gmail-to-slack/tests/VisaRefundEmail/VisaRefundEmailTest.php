<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\VisaRefundEmail;

use PHPUnit\Framework\TestCase;

final class VisaRefundEmailTest extends TestCase
{
    public function test_parse_email_body(): void
    {
        $email = new VisaRefundEmail(
            \file_get_contents(__DIR__ . '/VisaRefundEmail.txt')
        );
        self::assertSame(
            [
                $email->dateOfRefund()->format('Y-m-d H:i:s'),
                $email->amount(),
                $email->shopName(),
                $email->transactionId(),
            ],
            [
                '2019-07-05 20:07:02',
                10000,
                'ＭＯＢＩＬＥ　ＳＵＩＣＡ　ＵＣ',
                '2A186001',
            ]
        );
    }
}
