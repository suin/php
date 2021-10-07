<?php

declare(strict_types=1);

namespace SymplifyCsFixer;

use PHPUnit\Framework\TestCase;

/** @noinspection EfferentObjectCouplingInspection */
class FixersListTest extends TestCase
{
    public function test_list_fixers(): void
    {
        $expectedList = $this->getExpectedFixers();
        $actualList = \iterator_to_array(new SymplifyCsFixers());
        self::assertSameClasses($expectedList, $actualList);
    }

    private function getExpectedFixers(): array
    {
        return [
            new ArrayListItemNewlineFixer(),
            new ArrayOpenerAndCloserNewlineFixer(),
            new BlankLineAfterStrictTypesFixer(),
            new DocBlockLineLengthFixer(),
            new DoctrineAnnotationNestedBracketsFixer(),
            new LineLengthFixer(),
            new MethodChainingNewlineFixer(),
            new NewlineServiceDefinitionConfigFixer(),
            new ParamReturnAndVarTagMalformsFixer(),
            new RemovePHPStormAnnotationFixer(),
            new RemoveUselessDefaultCommentFixer(),
            new SpaceAfterCommaHereNowDocFixer(),
            new StandaloneLineInMultilineArrayFixer(),
            new StandaloneLinePromotedPropertyFixer(),
            new StandardizeHereNowDocKeywordFixer(),
        ];
    }

    private static function assertSameClasses(
        array $expectedList,
        array $actualList
    ): void {
        $expectedClasses = \array_map('\get_class', $expectedList);
        $actualClasses = \array_map('\get_class', $actualList);
        self::assertSame($expectedClasses, $actualClasses);
    }
}
