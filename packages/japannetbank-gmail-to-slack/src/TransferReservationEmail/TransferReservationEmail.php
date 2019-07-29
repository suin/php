<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\TransferReservationEmail;

use Suin\Jnb\GmailToSlack\VisaRefundEmail\VisaRefundEmailParseException;

/**
 * 振込予約のご確認メール
 */
final class TransferReservationEmail
{
    /**
     * @var \DateTimeImmutable
     */
    private $transferredOn;

    /**
     * @var string
     */
    private $receptionNumber;

    /**
     * @var string
     */
    private $payeeName;

    /**
     * @var int
     */
    private $amount;

    /**
     * @throws VisaRefundEmailParseException
     */
    public function __construct(string $body)
    {
        $this->transferredOn = self::parseTransferredOn($body);
        $this->receptionNumber = self::parseReceptionNumber($body);
        $this->payeeName = self::parsePayeeName($body);
        $this->amount = self::parseAmount($body);
    }

    /**
     * 振込指定日
     */
    public function transferredOn(): \DateTimeImmutable
    {
        return $this->transferredOn;
    }

    /**
     * 受付番号
     */
    public function receptionNumber(): string
    {
        return $this->receptionNumber;
    }

    /**
     * 受取人名
     */
    public function payeeName(): string
    {
        return $this->payeeName;
    }

    /**
     * 振込金額
     */
    public function amount(): int
    {
        return $this->amount;
    }

    private static function parseTransferredOn(string $body): \DateTimeImmutable
    {
        $date = self::parseBody(
            $body,
            '#振込指定日:(?<value>\d{4}/\d{2}/\d{2})#u',
            '振込指定日'
        );

        try {
            return new \DateTimeImmutable("{$date} Asia/Tokyo");
        } catch (\Exception $exception) {
            throw new VisaRefundEmailParseException(
                'Unable to decode 振込指定日 into DateTime',
                $body,
                $exception
            );
        }
    }

    private static function parseReceptionNumber(string $body): string
    {
        return \trim(
            self::parseBody(
                $body,
                '#受付番号:(?<value>.+)#u',
                '受付番号'
            )
        );
    }

    private static function parsePayeeName(string $body): string
    {
        return \trim(
            self::parseBody(
                $body,
                '#受取人名:(?<value>.+)#u',
                '受取人名'
            )
        );
    }

    private static function parseAmount(string $body): int
    {
        return (int) \str_replace(
            ',',
            '',
            self::parseBody(
                $body,
                '#振込金額:(?<value>[\d,]+)円#u',
                '振込金額'
            )
        );
    }

    private static function parseBody(
        string $body,
        string $pattern,
        string $name
    ): string {
        if (!\preg_match($pattern, $body, $matches)) {
            throw new VisaRefundEmailParseException(
                "Unable to parse {$name}",
                $body
            );
        }

        return (string) $matches['value'];
    }
}
