<?php

declare(strict_types=1);

namespace Suin\PhpCodeSniffer\PSR4ClassNameSniff;

final class ClassFileUnderInspection
{
    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $className;

    public function __construct(string $fileName, string $className)
    {
        $this->fileName = $fileName;
        $this->className = \ltrim($className, '\\');
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getClassName(): string
    {
        return $this->className;
    }
}
