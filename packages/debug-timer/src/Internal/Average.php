<?php

declare(strict_types=1);

namespace Suin\Debug\Timer\Internal;

final class Average
{
    /**
     * @param Duration[] $durations
     */
    public static function calculate(array $durations): Duration
    {
        $sum = new Duration(0.0);
        $count = \count($durations);

        if ($count === 0) {
            return $sum;
        }

        foreach ($durations as $duration) {
            $sum = $sum->add($duration);
        }

        return $sum->div($count);
    }
}
