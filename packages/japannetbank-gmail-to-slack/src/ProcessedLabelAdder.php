<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack;

use Google_Service_Gmail;
use Google_Service_Gmail_ModifyMessageRequest;

final class ProcessedLabelAdder
{
    /**
     * @var string
     */
    private $processedLabelId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var Google_Service_Gmail
     */
    private $gmail;

    public function __construct(
        Google_Service_Gmail $gmail,
        string $userId,
        string $processedLabelId
    ) {
        $this->gmail = $gmail;
        $this->userId = $userId;
        $this->processedLabelId = $processedLabelId;
    }

    public function addLabel(string $messageId): void
    {
        $mods = new Google_Service_Gmail_ModifyMessageRequest();
        $mods->setAddLabelIds([$this->processedLabelId]);
        $this->gmail->users_messages->modify($this->userId, $messageId, $mods);
    }
}
