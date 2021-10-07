<?php

declare(strict_types=1);

namespace SymplifyCsFixer;

use Symplify\CodingStandard\Fixer\Annotation\DoctrineAnnotationNestedBracketsFixer as OriginalFixer;

final class DoctrineAnnotationNestedBracketsFixer extends Proxy\ConfigurableFixer
{
    public const NAME = 'Symplify/doctrine_annotations_nested_brackets';

    protected const ORIGINAL_FIXER_CLASS = OriginalFixer::class;
}
