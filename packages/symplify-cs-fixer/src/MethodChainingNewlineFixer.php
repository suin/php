<?php

declare(strict_types=1);

namespace SymplifyCsFixer;

use Symplify\CodingStandard\Fixer\Spacing\MethodChainingNewlineFixer as OriginalFixer;

final class MethodChainingNewlineFixer extends Proxy\FixerProxy
{
    public const NAME = 'Symplify/method_chaining_newline';

    protected const ORIGINAL_FIXER_CLASS = OriginalFixer::class;
}
