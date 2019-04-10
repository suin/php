<?php

declare(strict_types=1);

namespace Suin\Debug\Timer\Internal;

final class Median
{
    /**
     * @param Duration[] $durations
     */
    public static function calculate(array $durations): Duration
    {
        $durations = self::sortedDurations($durations);
        $size = \count($durations);
        /** @var int $center */
        $center = \intdiv($size, 2);
        return $size % 2 === 0
            ? $durations[$center - 1]->add($durations[$center])->div(2)
            : $durations[$center];
    }

    /**
     * @param Duration[] $durations
     *
     * @return Duration[]
     */
    private static function sortedDurations(array $durations): array
    {
        \usort(
            $durations,
            function (Duration $duration1, Duration $duration2): int {
                return $duration1->seconds() <=> $duration2->seconds();
            }
        );
        return $durations;
    }
}
