<?php

declare(strict_types=1);

namespace Suin\PhpCodeSniffer\PSR4ClassNameSniff;

final class PSR4Directory
{
    /**
     * @var string
     */
    private $directory;

    /**
     * @var string
     */
    private $namespace;

    public function __construct(string $directory, string $namespace)
    {
        $this->directory = \rtrim($directory, '/') . '/';
        $this->namespace = \rtrim($namespace, '\\') . '\\';
    }

    public function inspect(
        ClassFileUnderInspection $classFile
    ): PSR4ClassNameInspectionResult {
        return $this->checkIfClassManagedUnderPSR4($classFile) ?
            $this->checkIfPSR4ValidClass($classFile) :
            new PSR4UnmanagedClass($classFile->getFileName());
    }

    private function checkIfPSR4ValidClass(
        ClassFileUnderInspection $classFile
    ): PSR4ClassNameInspectionResult {
        $expectedClassName = $this->getExpectedClassName($classFile);
        $actualClassName = $classFile->getClassName();
        return $expectedClassName === $actualClassName ?
            new PSR4ValidPSR4Class($expectedClassName) :
            new PSR4InvalidPSR4Class($expectedClassName, $actualClassName);
    }

    private function getExpectedClassName(
        ClassFileUnderInspection $classFile
    ): string {
        $relativeFileName = $this->getRelativeFileNameOf($classFile);
        $relativeClassName = $this->getRelativeClassNameOf($relativeFileName);
        $absoluteClassName = $this->getAbsoluteClassNameOf($relativeClassName);
        return $absoluteClassName;
    }

    private function getRelativeFileNameOf(
        ClassFileUnderInspection $classFile
    ): string {
        \assert($this->directoryEndsWithSlash());
        \assert($this->checkIfClassManagedUnderPSR4($classFile));
        return \substr($classFile->getFileName(), \strlen($this->directory));
    }

    private function getRelativeClassNameOf(string $relativeFileName): string
    {
        $basename = \basename($relativeFileName);
        $filename = \pathinfo($relativeFileName, \PATHINFO_FILENAME);
        $dirname = $basename === $relativeFileName ?
            '' :
            \pathinfo($relativeFileName, \PATHINFO_DIRNAME) . '/';
        return \str_replace('/', '\\', $dirname) . $filename;
    }

    private function getAbsoluteClassNameOf(string $relativeClassName): string
    {
        \assert($this->namespaceEndsWithBackslash());
        return $this->namespace . $relativeClassName;
    }

    private function checkIfClassManagedUnderPSR4(
        ClassFileUnderInspection $classFile
    ): bool {
        return \strpos($classFile->getFileName(), $this->directory) === 0;
    }

    private function namespaceEndsWithBackslash(): bool
    {
        return \substr($this->namespace, -1) === '\\';
    }

    private function directoryEndsWithSlash(): bool
    {
        return \substr($this->directory, -1) === '/';
    }
}
