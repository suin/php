<?php

declare(strict_types=1);

namespace Suin\PhpCodeSniffer\PSR4ClassNameSniff;

use PHPUnit\Framework\TestCase;

final class ExampleTest extends TestCase
{
    /**
     * @test
     */
    public function example(): void
    {
        $psr4 = new PSR4Directories(
            new PSR4Directory(
                'packages/validator/src',
                'Monorepo\\Component\\Validator\\'
            ),
            new PSR4Directory(
                'packages/validator/test/unit',
                'Test\\Unit\\Monorepo\\Component\\Validator\\'
            ),
            new PSR4Directory(
                'packages/validator/test/integration',
                'Test\\Integration\\Monorepo\\Component\\Validator\\'
            )
        );

        $validClassFile = new ClassFileUnderInspection(
            'packages/validator/src/Validator.php',
            'Monorepo\\Component\\Validator\\Validator'
        );

        $result = $psr4->inspect($validClassFile);
        self::assertTrue($result->isPSR4CorrectClassName());

        $invalidClassFile = new ClassFileUnderInspection(
            'packages/validator/test/unit/ValidatorTest.php',
            'Monorepo\\Component\\Validator\\ValidatorTest'
        );

        /** @var PSR4InvalidPSR4Class $result */
        $result = $psr4->inspect($invalidClassFile);
        self::assertFalse($result->isPSR4CorrectClassName());
        self::assertSame(
            'Monorepo\\Component\\Validator\\ValidatorTest',
            $result->getActualClassName()
        );
        self::assertSame(
            'Test\\Unit\\Monorepo\\Component\\Validator\\ValidatorTest',
            $result->getExpectedClassName()
        );
    }
}
