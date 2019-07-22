<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\Slack;

use Suin\Jnb\GmailToSlack\VisaRefundEmail\VisaRefundEmail;

final class VisaRefundMessageMaker
{
    public function makeMessage(VisaRefundEmail $email): SlackMessage
    {
        return new SlackMessage(
            '',
            [
                'text' => 'JNB VISAデビットの *返金* がありました。',
                'color' => 'good',
                'fields' => [
                    [
                        'title' => '返金日時',
                        'value' => $email->dateOfRefund()->format(
                            'Y-m-d H:i:s'
                        ),
                        'short' => true,
                    ],
                    [
                        'title' => '返金額',
                        'value' => \number_format($email->amount()) . '円',
                        'short' => true,
                    ],
                    [
                        'title' => '加盟店名',
                        'value' => $email->shopName(),
                        'short' => true,
                    ],
                    [
                        'title' => '取引明細番号',
                        'value' => $email->transactionId(),
                        'short' => true,
                    ],
                ],
            ]
        );
    }
}
