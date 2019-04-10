<?php

declare(strict_types=1);

namespace Suin\Debug\Timer;

use Suin\Debug\Timer\Internal\FileLogger;
use Suin\Debug\Timer\Internal\OneTimeTimer;
use Suin\Debug\Timer\Internal\TimerContext;

final class Timer
{
    /**
     * @var OneTimeTimer
     */
    private $timer;

    public function __construct(string $label)
    {
        $this->timer = new OneTimeTimer($label);
    }

    public function stop(): void
    {
        $this->timer->stop(TimerContext::timerStoppedObserver());
    }

    public static function useLogFile(string $filename): void
    {
        TimerContext::replaceDurationAddedObserver(
            FileLogger::withFilename($filename)
        );
    }

    public static function useDefaultLogFile(): void
    {
        TimerContext::replaceDurationAddedObserverWithDefault();
    }
}
