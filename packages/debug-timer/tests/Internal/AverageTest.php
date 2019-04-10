<?php

declare(strict_types=1);

namespace Suin\Debug\Timer\Internal;

use PHPUnit\Framework\TestCase;

final class AverageTest extends TestCase
{
    /**
     * @dataProvider patterns
     */
    public function test_calculation(array $durations, Duration $expected): void
    {
        self::assertSame(
            $expected->microseconds(),
            Average::calculate($durations)->microseconds()
        );
    }

    public function patterns(): iterable
    {
        yield [[], new Duration(0.0)];
        yield [[new Duration(0.001)], new Duration(0.001)];
        yield [
            [new Duration(0.0001), new Duration(0.0099)],
            new Duration(0.005),
        ];
    }
}
