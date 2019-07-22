<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack;

final class Email
{
    /**
     * @var string
     */
    private $emailId;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $body;

    /**
     * @var ProcessedLabelAdder
     */
    private $processedLabelAdder;

    public function __construct(
        string $emailId,
        string $subject,
        string $body,
        ProcessedLabelAdder $processedLabelAdder
    ) {
        $this->emailId = $emailId;
        $this->subject = $subject;
        $this->body = $body;
        $this->processedLabelAdder = $processedLabelAdder;
    }

    public function emailId(): string
    {
        return $this->emailId;
    }

    public function subject(): string
    {
        return $this->subject;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function markProcessed(): void
    {
        $this->processedLabelAdder->addLabel($this->emailId);
    }
}
