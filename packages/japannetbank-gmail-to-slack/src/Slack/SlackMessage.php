<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack\Slack;

final class SlackMessage
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var array
     */
    private $attachments = [];

    public function __construct(string $text, array $attachments)
    {
        $this->text = $text;
        $this->attachments = $attachments;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function attachment(): array
    {
        return $this->attachments;
    }
}
