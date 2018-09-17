<?php

declare(strict_types=1);

namespace Suin\PhpCodeSniffer\PSR4ClassNameSniff;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\ClassHelper;
use SlevomatCodingStandard\Helpers\TokenHelper;

final class PSR4ClassNameSniff implements Sniff
{
    /**
     * @var string
     */
    public $composer;

    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return [
            T_CLASS,
            T_INTERFACE,
            T_TRAIT,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, $typePointer): void
    {
        $config = $this->getAutoloadConfiguration();

        $psr4Dirs = [];

        foreach ($config as $namespace => $directory) {
            $psr4Dirs[] = new PSR4Directory($directory, $namespace);
        }
        $psr4Dirs = new PSR4Directories(...$psr4Dirs);

        $className = ClassHelper::getFullyQualifiedName(
            $phpcsFile,
            $typePointer
        );
        $classFile = new ClassFileUnderInspection(
            $phpcsFile->getFilename(),
            $className
        );

        $result = $psr4Dirs->inspect($classFile);

        if ($result instanceof PSR4InvalidPSR4Class) {
            $this->addError($phpcsFile, $result, $typePointer);
        }
    }

    private function getAutoloadConfiguration(): iterable
    {
        $composerJson = json_decode(file_get_contents($this->composer), true);
        yield from $composerJson['autoload']['psr-4'] ?? [];
        yield from $composerJson['autoload-dev']['psr-4'] ?? [];
    }

    private function addError(
        File $phpcsFile,
        PSR4InvalidPSR4Class $result,
        int $typePointer
    ): void {
        $phpcsFile->addError(
            sprintf(
                'Class name %s should be %s',
                $result->getActualClassName(),
                $result->getExpectedClassName()
            ),
            $this->getClassNameDeclarationPosition($phpcsFile, $typePointer),
            'InvalidClassName'
        );
    }

    private function getClassNameDeclarationPosition(
        File $phpcsFile,
        int $typePointer
    ): ?int {
        return TokenHelper::findNext($phpcsFile, T_STRING, $typePointer + 1);
    }
}
