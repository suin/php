<?php

declare(strict_types=1);

namespace Suin\Debug\Timer\Internal;

use InvalidArgumentException;

final class FileLogger implements DurationAddedObserver
{
    /**
     * @var resource
     */
    private $resource;

    /**
     * @var int
     */
    private $count = 0;

    /**
     * @param resource $resource
     */
    public function __construct($resource)
    {
        if (!\is_resource($resource)) {
            throw new InvalidArgumentException(
                'The first parameter must be resource type'
            );
        }
        $this->resource = $resource;
    }

    public static function withFilename(string $filename): self
    {
        return new self(\fopen($filename, 'a+b'));
    }

    public function onDurationAdded(
        Duration $durationAdded,
        DurationSet $newDurationSet
    ): void {
        if ($this->count === 0) {
            \fwrite(
                $this->resource,
                "      Average |        Median |      Duration | Times | Label\n"
            );
        }
        \fwrite(
            $this->resource,
            $this->formatDurationSet($durationAdded, $newDurationSet)
        );
        $this->count++;
    }

    private function formatDurationSet(
        Duration $duration,
        DurationSet $durationSet
    ): string {
        $values = [
            self::formatDuration(Average::calculate($durationSet->toArray())),
            self::formatDuration(Median::calculate($durationSet->toArray())),
            self::formatDuration($duration),
            self::formatIteration($durationSet),
            $durationSet->label(),
        ];
        return \implode(' | ', $values) . "\n";
    }

    private static function formatDuration(Duration $duration): string
    {
        return \str_pad(
            \number_format($duration->microseconds()) . 'μs',
            14,
            ' ',
            \STR_PAD_LEFT
        );
    }

    private static function formatIteration(DurationSet $durationSet): string
    {
        return \str_pad(
            \number_format(\count($durationSet->toArray())),
            5,
            ' ',
            \STR_PAD_LEFT
        );
    }
}
