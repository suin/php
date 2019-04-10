<?php

declare(strict_types=1);

namespace Suin\Debug\Timer\Internal;

final class DurationSet
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var Duration[]
     */
    private $durations = [];

    public function __construct(string $label, Duration ...$durations)
    {
        $this->label = $label;
        $this->durations = $durations;
    }

    public function add(Duration $duration): self
    {
        return new self($this->label, ...$this->durations, ...[$duration]);
    }

    public function label(): string
    {
        return $this->label;
    }

    /**
     * @return Duration[]
     */
    public function toArray(): array
    {
        return $this->durations;
    }
}
