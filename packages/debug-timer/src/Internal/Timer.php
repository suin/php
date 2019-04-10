<?php

declare(strict_types=1);

namespace Suin\Debug\Timer\Internal;

final class Timer
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var float
     */
    private $startedOn;

    /**
     * @var null|callable<float>
     */
    private static $fixedCurrentTime;

    public function __construct(string $label)
    {
        $this->label = $label;
        $this->startedOn = self::currentTime();
    }

    public function stop(TimerStoppedObserver $observer): void
    {
        $observer->onTimerStopped($this->label, $this->duration());
    }

    /**
     * This method is used for debugging.
     */
    public static function fixCurrentTime(callable $fixedCurrentTime): void
    {
        self::$fixedCurrentTime = $fixedCurrentTime;
    }

    public static function unfixCurrentTime(): void
    {
        self::$fixedCurrentTime = null;
    }

    private function duration(): Duration
    {
        return new Duration(self::currentTime() - $this->startedOn);
    }

    /** @noinspection ClassMethodNameMatchesFieldNameInspection */
    private static function currentTime(): float
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return self::$fixedCurrentTime === null
            ? \microtime(true)
            : (self::$fixedCurrentTime)();
    }
}
