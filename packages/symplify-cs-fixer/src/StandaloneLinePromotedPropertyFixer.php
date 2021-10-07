<?php

declare(strict_types=1);

namespace SymplifyCsFixer;

use Symplify\CodingStandard\Fixer\Spacing\StandaloneLinePromotedPropertyFixer as OriginalFixer;

final class StandaloneLinePromotedPropertyFixer extends Proxy\FixerProxy
{
    public const NAME = 'Symplify/standalone_line_promoted_property';

    protected const ORIGINAL_FIXER_CLASS = OriginalFixer::class;
}
