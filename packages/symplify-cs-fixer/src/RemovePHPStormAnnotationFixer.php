<?php

declare(strict_types=1);

namespace SymplifyCsFixer;

use Symplify\CodingStandard\Fixer\Annotation\RemovePHPStormAnnotationFixer as OriginalFixer;

final class RemovePHPStormAnnotationFixer extends Proxy\FixerProxy
{
    public const NAME = 'Symplify/remove_php_storm_annotation';

    protected const ORIGINAL_FIXER_CLASS = OriginalFixer::class;
}
