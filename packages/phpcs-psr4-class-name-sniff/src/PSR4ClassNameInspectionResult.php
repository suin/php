<?php

declare(strict_types=1);

namespace Suin\PhpCodeSniffer\PSR4ClassNameSniff;

interface PSR4ClassNameInspectionResult
{
    public function isPSR4CorrectClassName(): bool;

    public function isManagedUnderPSR4(): bool;
}
