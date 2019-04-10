<?php

declare(strict_types=1);

namespace Suin\Debug\Timer\Internal;

interface TimerStoppedObserver
{
    public function onTimerStopped(string $label, Duration $duration): void;
}
