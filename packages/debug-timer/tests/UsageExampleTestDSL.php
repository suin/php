<?php

declare(strict_types=1);

namespace Suin\Debug\Timer;

trait UsageExampleTestDSL
{
    /**
     * @var resource
     */
    private $output;

    /**
     * @var int
     */
    private $elapsedTimeInMicroseconds = 0;

    /**
     * @var int
     */
    private $fixedDurationInMicroseconds = 1000;

    final protected function setUp(): void
    {
        parent::setUp();
        $this->fixLogFilename();
        $this->fixCurrentTime();
    }

    final protected function tearDown(): void
    {
        parent::tearDown();
        Timer::useDefaultLogFile();
        Internal\Timer::unfixCurrentTime();
    }

    private function sleepMicroseconds(int $microseconds): void
    {
        $this->elapsedTimeInMicroseconds += $microseconds;
    }

    private function fixLogFilename(): void
    {
        $this->output = \tmpfile();
        Timer::useLogFile(\stream_get_meta_data($this->output)['uri']);
    }

    private function fixCurrentTime(): void
    {
        Internal\Timer::fixCurrentTime(
            function () {
                return $this->elapsedTimeInMicroseconds / 1000000;
            }
        );
    }

    private function theTimerWillReports(string $string): void
    {
        \rewind($this->output);
        self::assertSame($string, \stream_get_contents($this->output));
    }
}
