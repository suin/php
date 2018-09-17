<?php

declare(strict_types=1);

namespace Suin\PhpCodeSniffer\PSR4ClassNameSniff;

final class PSR4Directories
{
    /**
     * @var PSR4Directory[]
     */
    private $directories;

    public function __construct(PSR4Directory ...$directories)
    {
        $this->directories = $directories;
    }

    public function inspect(
        ClassFileUnderInspection $classFile
    ): PSR4ClassNameInspectionResult {
        $result = new PSR4UnmanagedClass($classFile->getFileName());

        foreach ($this->directories as $directory) {
            $result = $directory->inspect($classFile);

            if ($result->isManagedUnderPSR4()) {
                break;
            }
        }
        return $result;
    }
}
