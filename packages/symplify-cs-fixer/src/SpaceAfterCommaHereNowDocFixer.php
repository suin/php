<?php

declare(strict_types=1);

namespace SymplifyCsFixer;

use Symplify\CodingStandard\Fixer\Spacing\SpaceAfterCommaHereNowDocFixer as OriginalFixer;

final class SpaceAfterCommaHereNowDocFixer extends Proxy\FixerProxy
{
    public const NAME = 'Symplify/space_after_comma_here_now_doc';

    protected const ORIGINAL_FIXER_CLASS = OriginalFixer::class;
}
