<?php

declare(strict_types=1);

namespace Suin\Debug\Timer\Internal;

final class DurationSets implements TimerStoppedObserver
{
    /**
     * @var DurationSet[]
     */
    private $durationSets = [];

    /**
     * @var DurationAddedObserver
     */
    private $observer;

    public function __construct(DurationAddedObserver $observer)
    {
        $this->observer = $observer;
    }

    public function onTimerStopped(string $label, Duration $duration): void
    {
        $this->addDurationToDurationSet($label, $duration);
    }

    private function addDurationToDurationSet(
        string $label,
        Duration $duration
    ): void {
        $newDurationSet = $this->durationSetOf($label)->add($duration);
        $this->durationSets[$label] = $newDurationSet;
        $this->observer->onDurationAdded($duration, $newDurationSet);
    }

    private function durationSetOf(string $label): DurationSet
    {
        return $this->durationSets[$label] ?? new DurationSet($label);
    }
}
