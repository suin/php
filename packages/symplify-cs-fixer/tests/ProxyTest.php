<?php

declare(strict_types=1);

namespace SymplifyCsFixer;

use PhpCsFixer\Fixer\ConfigurableFixerInterface;
use PHPUnit\Framework\TestCase;
use SymplifyCsFixer\Proxy\FixerProxy;
use PhpCsFixer\Fixer\FixerInterface;

/** @noinspection EfferentObjectCouplingInspection */
class ProxyTest extends TestCase
{
    private const CONFIGURABLE = true;

    private const UNCONFIGURABLE = false;

    /**
     * @dataProvider getDefinedFixers
     */
    public function test_defined_fixers(
        string $proxyClass,
        string $name,
        bool $isConfigurable
    ): void {
        /** @var FixerProxy & string $proxyClass */
        /** @var FixerProxy $fixer */
        $fixer = new $proxyClass();
        self::assertInstanceOf(FixerInterface::class, $fixer);

        if ($isConfigurable) {
            self::assertConfigurableFixer($fixer);
        } else {
            self::assertNotConfigurableFixer($fixer);
        }
        self::assertSame($name, $fixer->getName());
        self::assertSame($name, $proxyClass::NAME);
    }

    public function getDefinedFixers(): iterable
    {
        return [
            [
                ArrayListItemNewlineFixer::class,
                'Symplify/array_list_item_newline',
                self::UNCONFIGURABLE,
            ],
            [
                ArrayOpenerAndCloserNewlineFixer::class,
                'Symplify/array_opener_and_closer_newline_fixer',
                self::UNCONFIGURABLE,
            ],
            [
                BlankLineAfterStrictTypesFixer::class,
                'Symplify/blank_line_after_strict_types',
                self::UNCONFIGURABLE,
            ],
            [
                DocBlockLineLengthFixer::class,
                'Symplify/docblock_line_length',
                self::CONFIGURABLE,
            ],
            [
                DoctrineAnnotationNestedBracketsFixer::class,
                'Symplify/doctrine_annotations_nested_brackets',
                self::CONFIGURABLE,
            ],
            [
                LineLengthFixer::class,
                'Symplify/line_length',
                self::CONFIGURABLE,
            ],
            [
                MethodChainingNewlineFixer::class,
                'Symplify/method_chaining_newline',
                self::UNCONFIGURABLE,
            ],
            [
                NewlineServiceDefinitionConfigFixer::class,
                'Symplify/newline_service_definition_config',
                self::UNCONFIGURABLE,
            ],
            [
                ParamReturnAndVarTagMalformsFixer::class,
                'Symplify/param_return_and_var_tag_malforms',
                self::UNCONFIGURABLE,
            ],
            [
                RemovePHPStormAnnotationFixer::class,
                'Symplify/remove_php_storm_annotation',
                self::UNCONFIGURABLE,
            ],
            [
                RemoveUselessDefaultCommentFixer::class,
                'Symplify/remove_useless_default_comment',
                self::UNCONFIGURABLE,
            ],
            [
                SpaceAfterCommaHereNowDocFixer::class,
                'Symplify/space_after_comma_here_now_doc',
                self::UNCONFIGURABLE,
            ],
            [
                StandaloneLineInMultilineArrayFixer::class,
                'Symplify/standalone_line_in_multiline_array',
                self::UNCONFIGURABLE,
            ],
            [
                StandaloneLinePromotedPropertyFixer::class,
                'Symplify/standalone_line_promoted_property',
                self::UNCONFIGURABLE,
            ],
            [
                StandardizeHereNowDocKeywordFixer::class,
                'Symplify/standardize_here_now_doc_keyword',
                self::CONFIGURABLE,
            ],
        ];
    }

    private static function assertConfigurableFixer(FixerProxy $fixer): void
    {
        self::assertInstanceOf(ConfigurableFixerInterface::class, $fixer);
    }

    private static function assertNotConfigurableFixer(FixerProxy $fixer): void
    {
        self::assertNotInstanceOf(
            ConfigurableFixerInterface::class,
            $fixer
        );
    }
}
