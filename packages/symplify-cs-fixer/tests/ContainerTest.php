<?php

declare(strict_types=1);

namespace SymplifyCsFixer;

use PHPUnit\Framework\TestCase;
use Symplify\EasyCodingStandard\Console\EasyCodingStandardApplication;
use SymplifyCsFixer\Container\Container;

final class ContainerTest extends TestCase
{
    public function testName(): void
    {
        $a = Container::get(EasyCodingStandardApplication::class);
    }
}
