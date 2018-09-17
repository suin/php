<?php

declare(strict_types=1);

namespace Suin\PhpCodeSniffer\PSR4ClassNameSniff;

final class PSR4InvalidPSR4Class implements PSR4ClassNameInspectionResult
{
    /**
     * @var string
     */
    private $expectedClassName;

    /**
     * @var string
     */
    private $actualClassName;

    public function __construct(
        string $expectedClassName,
        string $actualClassName
    ) {
        $this->expectedClassName = $expectedClassName;
        $this->actualClassName = $actualClassName;
    }

    public function isPSR4CorrectClassName(): bool
    {
        return false;
    }

    public function isManagedUnderPSR4(): bool
    {
        return true;
    }

    public function getExpectedClassName(): string
    {
        return $this->expectedClassName;
    }

    public function getActualClassName(): string
    {
        return $this->actualClassName;
    }
}
