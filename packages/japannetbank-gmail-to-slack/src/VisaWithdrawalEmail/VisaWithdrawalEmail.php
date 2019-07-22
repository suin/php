<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\VisaWithdrawalEmail;

class VisaWithdrawalEmail
{
    /**
     * @var \DateTimeImmutable
     */
    private $dateOfWithdrawal;

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
     * @throws VisaWithdrawalEmailParseException
     */
    public function __construct(string $body)
    {
        $this->dateOfWithdrawal = self::parseDateOfWithdrawal($body);
        $this->amount = self::parseAmount($body);
        $this->shopName = self::parseShopName($body);
        $this->transactionId = self::parseTransactionId($body);
    }

    /**
     * Returns お引落日時.
     */
    public function dateOfWithdrawal(): \DateTimeImmutable
    {
        return $this->dateOfWithdrawal;
    }

    /**
     * Returns お引落金額.
     */
    public function amount(): int
    {
        return $this->amount;
    }

    /**
     * Returns 加盟店名.
     */
    public function shopName(): string
    {
        return $this->shopName;
    }

    /**
     * Returns 取引明細番号.
     */
    public function transactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @throws VisaWithdrawalEmailParseException
     */
    private static function parseDateOfWithdrawal(
        string $body
    ): \DateTimeImmutable {
        $date = self::parseBody(
            $body,
            '#お引落日時：(?<value>\d{4}/\d{2}/\d{2} \d{2}:\d{2}:\d{2})#u',
            'お引落日時'
        );

        try {
            return new \DateTimeImmutable("{$date} Asia/Tokyo");
        } catch (\Exception $exception) {
            throw new VisaWithdrawalEmailParseException(
                'Unable to decode お引落日時 into DateTime',
                $body,
                $exception
            );
        }
    }

    /**
     * @throws VisaWithdrawalEmailParseException
     */
    private static function parseAmount(string $body): int
    {
        return (int) \str_replace(
            ',',
            '',
            self::parseBody(
                $body,
                '#お引落金額：(?<value>[\d,]+)円#u',
                'お引落金額'
            )
        );
    }

    /**
     * @throws VisaWithdrawalEmailParseException
     */
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

    /**
     * @throws VisaWithdrawalEmailParseException
     */
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
            throw new VisaWithdrawalEmailParseException(
                "Unable to parse {$name}",
                $body
            );
        }

        return (string) $matches['value'];
    }
}
