<?php

declare(strict_types=1);

namespace Suin\PhpCodeSniffer\PSR4ClassNameSniff;

final class PSR4ValidPSR4Class implements PSR4ClassNameInspectionResult
{
    /**
     * @var string
     */
    private $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function isPSR4CorrectClassName(): bool
    {
        return true;
    }

    public function isManagedUnderPSR4(): bool
    {
        return true;
    }

    public function getClassName(): string
    {
        return $this->className;
    }
}
