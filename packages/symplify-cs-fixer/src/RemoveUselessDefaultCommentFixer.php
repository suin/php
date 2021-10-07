<?php

declare(strict_types=1);

namespace SymplifyCsFixer;

use Symplify\CodingStandard\Fixer\Commenting\RemoveUselessDefaultCommentFixer as OriginalFixer;

final class RemoveUselessDefaultCommentFixer extends Proxy\FixerProxy
{
    public const NAME = 'Symplify/remove_useless_default_comment';

    protected const ORIGINAL_FIXER_CLASS = OriginalFixer::class;
}
