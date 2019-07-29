<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\Slack;

use Suin\Jnb\GmailToSlack\TransferReservationEmail\TransferReservationEmail;

final class TransferReservationMessageMaker
{
    public function makeMessage(TransferReservationEmail $email): SlackMessage
    {
        return new SlackMessage(
            '',
            [
                'text' => '*振込予約* を受け付けました。',
                'color' => 'warning',
                'fields' => [
                    [
                        'title' => '振込指定日',
                        'value' => $email->transferredOn()->format('Y-m-d'),
                        'short' => true,
                    ],
                    [
                        'title' => '振込金額',
                        'value' => \number_format($email->amount()) . '円',
                        'short' => true,
                    ],
                    [
                        'title' => '受取人名',
                        'value' => $email->payeeName() . ' (一部伏せ字)',
                        // JNBから送られてくるメール自体が「※受取人名は一部のみ表示しております」になっているため。
                        'short' => true,
                    ],
                    [
                        'title' => '受付番号',
                        'value' => $email->receptionNumber(),
                        'short' => true,
                    ],
                ],
            ]
        );
    }
}
