<?php

declare(strict_types=1);

namespace Suin\Debug\Timer\Internal;

final class Duration
{
    /**
     * @var float
     */
    private $seconds;

    public function __construct(float $seconds)
    {
        $this->seconds = $seconds;
    }

    public function microseconds(): float
    {
        return $this->seconds * 1000000;
    }

    public function seconds(): float
    {
        return $this->seconds;
    }

    public function add(self $duration): self
    {
        return new self($this->seconds + $duration->seconds);
    }

    public function div(float $divisor): self
    {
        return new self($this->seconds / $divisor);
    }
}
