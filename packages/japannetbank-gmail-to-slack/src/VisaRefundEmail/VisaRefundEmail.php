<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\VisaRefundEmail;

final class VisaRefundEmail
{
    /**
     * @var \DateTimeImmutable
     */
    private $dateOfRefund;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $shopName;

    /**
     * @var string
     */
    private $transactionId;

    /**
     * @throws VisaRefundEmailParseException
     */
    public function __construct(string $body)
    {
        $this->dateOfRefund = self::parseDateOfRefund($body);
        $this->amount = self::parseAmount($body);
        $this->shopName = self::parseShopName($body);
        $this->transactionId = self::parseTransactionId($body);
    }

    public function dateOfRefund(): \DateTimeImmutable
    {
        return $this->dateOfRefund;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function shopName(): string
    {
        return $this->shopName;
    }

    public function transactionId(): string
    {
        return $this->transactionId;
    }

    private static function parseDateOfRefund(string $body): \DateTimeImmutable
    {
        $date = self::parseBody(
            $body,
            '#ご返金日時：(?<value>\d{4}/\d{2}/\d{2} \d{2}:\d{2}:\d{2})#u',
            'ご返金日時'
        );

        try {
            return new \DateTimeImmutable("{$date} Asia/Tokyo");
        } catch (\Exception $exception) {
            throw new VisaRefundEmailParseException(
                'Unable to decode ご返金日時 into DateTime',
                $body,
                $exception
            );
        }
    }

    private static function parseAmount(string $body): int
    {
        return (int) \str_replace(
            ',',
            '',
            self::parseBody(
                $body,
                '#ご返金額：(?<value>[\d,]+)円#u',
                'ご返金額'
            )
        );
    }

    private static function parseShopName(string $body): string
    {
        return \trim(
            self::parseBody(
                $body,
                '#加盟店名：(?<value>.+)#u',
                '加盟店名'
            )
        );
    }

    private static function parseTransactionId(string $body): string
    {
        return \trim(
            self::parseBody(
                $body,
                '#取引明細番号：(?<value>.+)#u',
                '取引明細番号'
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
