<?php

declare(strict_types=1);

namespace SymplifyCsFixer;

use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer as OriginalFixer;

final class ArrayListItemNewlineFixer extends Proxy\FixerProxy
{
    public const NAME = 'Symplify/array_list_item_newline';

    protected const ORIGINAL_FIXER_CLASS = OriginalFixer::class;
}
