<?php

/** @noinspection DisconnectedForeachInstructionInspection */

declare(strict_types=1);

namespace Suin\Debug\Timer;

use PHPUnit\Framework\TestCase;

final class UsageExampleTest extends TestCase
{
    use UsageExampleTestDSL;

    /**
     * @test
     * @testdox Example #1 Measure the time of an operation inside a loop
     */
    public function example1(): void
    {
        foreach (\range(1, 5) as $time) {
            // 1. Instantiate the Timer class right before a block that you will
            // measure the time:
            $timer = new Timer('Some operation');

            // Some operation which you want to measure the time of.
            $this->sleepMicroseconds(1000);

            // 2. Call the stop method right after the end of the block.
            $timer->stop();
        }

        // 3. The timer reports the duration like followings:
        $this->theTimerWillReports(
            "      Average |        Median |      Duration | Times | Label\n" .
            "      1,000μs |       1,000μs |       1,000μs |     1 | Some operation\n" .
            "      1,000μs |       1,000μs |       1,000μs |     2 | Some operation\n" .
            "      1,000μs |       1,000μs |       1,000μs |     3 | Some operation\n" .
            "      1,000μs |       1,000μs |       1,000μs |     4 | Some operation\n" .
            "      1,000μs |       1,000μs |       1,000μs |     5 | Some operation\n"
        );
    }

    /**
     * @test
     * @testdox Example #2 Measure the multiple time
     */
    public function example2(): void
    {
        // 1. Measure an operation
        $timer = new Timer('An operation');
        $this->sleepMicroseconds(1000);
        $timer->stop();

        // 2. Measure another operation
        $timer = new Timer('Another operation');
        $this->sleepMicroseconds(2000);
        $timer->stop();

        // 3. The timer reports the duration like followings:
        $this->theTimerWillReports(
            "      Average |        Median |      Duration | Times | Label\n" .
            "      1,000μs |       1,000μs |       1,000μs |     1 | An operation\n" .
            "      2,000μs |       2,000μs |       2,000μs |     1 | Another operation\n"
        );
    }

    /**
     * @test
     * @testdox Example #3 Nested time measuring
     */
    public function example3(): void
    {
        $timer = new Timer('A loop');

        foreach (\range(1, 3) as $t) {
            $timer2 = new Timer('Each loop');
            $this->sleepMicroseconds(1000);
            $timer2->stop();
        }

        $timer->stop();

        $this->theTimerWillReports(
            "      Average |        Median |      Duration | Times | Label\n" .
            "      1,000μs |       1,000μs |       1,000μs |     1 | Each loop\n" .
            "      1,000μs |       1,000μs |       1,000μs |     2 | Each loop\n" .
            "      1,000μs |       1,000μs |       1,000μs |     3 | Each loop\n" .
            "      3,000μs |       3,000μs |       3,000μs |     1 | A loop\n"
        );
    }

    /**
     * @test
     * @testdox Warning: The 'stop' method should not be called twice or more.
     */
    public function warning1(): void
    {
        $timer = new Timer('Some operation');
        $timer->stop(); // This is OK

        $this->expectExceptionMessage(
            "The timer of 'Some operation' has already stopped"
        );
        // This raises an Exception since the method is called twice.
        $timer->stop();
    }
}
