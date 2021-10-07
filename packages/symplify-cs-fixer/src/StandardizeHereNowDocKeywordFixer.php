<?php

declare(strict_types=1);

namespace SymplifyCsFixer;

use Symplify\CodingStandard\Fixer\Naming\StandardizeHereNowDocKeywordFixer as OriginalFixer;

final class StandardizeHereNowDocKeywordFixer extends Proxy\ConfigurableFixer
{
    public const NAME = 'Symplify/standardize_here_now_doc_keyword';

    protected const ORIGINAL_FIXER_CLASS = OriginalFixer::class;
}
