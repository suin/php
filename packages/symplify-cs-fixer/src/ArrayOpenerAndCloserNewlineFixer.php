<?php

declare(strict_types=1);

namespace SymplifyCsFixer;

use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer as OriginalFixer;

final class ArrayOpenerAndCloserNewlineFixer extends Proxy\FixerProxy
{
    public const NAME = 'Symplify/array_opener_and_closer_newline_fixer';

    protected const ORIGINAL_FIXER_CLASS = OriginalFixer::class;
}
