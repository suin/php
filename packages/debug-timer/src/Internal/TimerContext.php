<?php

declare(strict_types=1);

namespace Suin\Debug\Timer\Internal;

final class TimerContext
{
    /**
     * @var DurationSets
     */
    private static $durationSets;

    /**
     * @var TimerStoppedObserver
     */
    private static $timerStoppedObserver;

    /**
     * @var DurationAddedObserver
     */
    private static $durationAddedObserver;

    public static function timerStoppedObserver(): TimerStoppedObserver
    {
        if (self::$timerStoppedObserver === null) {
            self::$timerStoppedObserver = self::durationSets();
        }
        return self::$timerStoppedObserver;
    }

    public static function replaceDurationAddedObserver(
        DurationAddedObserver $durationAddedObserver
    ): void {
        self::clear();
        self::$durationAddedObserver = $durationAddedObserver;
    }

    public static function replaceDurationAddedObserverWithDefault(): void
    {
        self::replaceDurationAddedObserver(self::createDurationAddedObserver());
    }

    private static function clear(): void
    {
        self::$durationSets = null;
        self::$timerStoppedObserver = null;
        self::$durationAddedObserver = null;
    }

    private static function durationSets(): DurationSets
    {
        if (self::$durationSets === null) {
            self::$durationSets = new DurationSets(
                self::durationAddedObserver()
            );
        }
        return self::$durationSets;
    }

    private static function durationAddedObserver(): DurationAddedObserver
    {
        if (self::$durationAddedObserver === null) {
            self::$durationAddedObserver = self::createDurationAddedObserver();
        }
        return self::$durationAddedObserver;
    }

    private static function createDurationAddedObserver(): FileLogger
    {
        return new FileLogger(\STDOUT);
    }
}
