<?php

declare(strict_types=1);

namespace Suin\PhpCodeSniffer\PSR4ClassNameSniff;

use LogicException;

final class PSR4UnmanagedClass implements PSR4ClassNameInspectionResult
{
    /**
     * @var string
     */
    private $classFileName;

    public function __construct(string $classFileName)
    {
        $this->classFileName = $classFileName;
    }

    public function isPSR4CorrectClassName(): bool
    {
        throw new LogicException(
            "Class file {$this->classFileName} is not managed under PSR-4"
        );
    }

    public function isManagedUnderPSR4(): bool
    {
        return false;
    }
}
