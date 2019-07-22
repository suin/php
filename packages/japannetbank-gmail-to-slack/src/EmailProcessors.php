<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack;

final class EmailProcessors
{
    /**
     * @var EmailProcessor[]
     */
    private $processors = [];

    public function __construct(EmailProcessor ...$processors)
    {
        $this->processors = $processors;
    }

    public function process(Email $email): void
    {
        foreach ($this->processors as $processor) {
            if ($processor->canProcess($email)) {
                $processor->process($email);
            }
        }
    }
}
