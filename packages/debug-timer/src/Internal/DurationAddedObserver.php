<?php

declare(strict_types=1);

namespace Suin\Debug\Timer\Internal;

interface DurationAddedObserver
{
    public function onDurationAdded(
        Duration $durationAdded,
        DurationSet $newDurationSet
    ): void;
}
