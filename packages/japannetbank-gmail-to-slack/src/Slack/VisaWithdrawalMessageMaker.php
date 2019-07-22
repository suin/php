<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\Slack;

use Suin\Jnb\GmailToSlack\VisaWithdrawalEmail\VisaWithdrawalEmail;

final class VisaWithdrawalMessageMaker
{
    public function makeMessage(VisaWithdrawalEmail $email): SlackMessage
    {
        return new SlackMessage(
            '',
            [
                'text' => 'JNB VISAデビットの *引き落とし* がありました。',
                'color' => 'danger',
                'fields' => [
                    [
                        'title' => '引落日時',
                        'value' => $email->dateOfWithdrawal()->format(
                            'Y-m-d H:i:s'
                        ),
                        'short' => true,
                    ],
                    [
                        'title' => '引落金額',
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
