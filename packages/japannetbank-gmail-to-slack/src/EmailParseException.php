<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack;

use Throwable;

abstract class EmailParseException extends \RuntimeException
{
    /**
     * @var string
     */
    private $body;

    final public function __construct(
        string $message,
        string $body,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
        $this->body = $body;
    }

    final public function getBody(): string
    {
        return $this->body;
    }
}
