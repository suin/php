# suin/debug-timer

Measures the time for debug.


## Installation

```
composer require --dev suin/debug-timer
```

## Usage

### Example #1 Measure the time of an operation inside a loop

```php
<?php

use Suin\Debug\Timer\Timer;

foreach (\range(1, 5) as $time) {
    // 1. Instantiate the Timer class right before a block that you will
    // measure the time:
    $timer = new Timer('Some operation');

    // Some operation which you want to measure the time of.
    usleep(1000);

    // 2. Call the stop method right after the end of the block.
    $timer->stop();
}
```

The output will be:

```
      Average |        Median |      Duration | Times | Label
      1,000μs |       1,000μs |       1,000μs |     1 | Some operation
      1,000μs |       1,000μs |       1,000μs |     2 | Some operation
      1,000μs |       1,000μs |       1,000μs |     3 | Some operation
      1,000μs |       1,000μs |       1,000μs |     4 | Some operation
      1,000μs |       1,000μs |       1,000μs |     5 | Some operation
```

Please see [more examples](./tests/UsageExampleTest.php)

## Changelog

Please see [CHANGELOG](https://github.com/suin/php/blob/master/CHANGELOG.md) for more details.

## Contributing

Send [issue](https://github.com/suin/php/issues) or [pull-request](https://github.com/suin/php/pulls) to main repository.
