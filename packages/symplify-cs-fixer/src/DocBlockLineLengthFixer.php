<?php

declare(strict_types=1);

namespace SymplifyCsFixer;

use Symplify\CodingStandard\Fixer\LineLength\DocBlockLineLengthFixer as OriginalFixer;

final class DocBlockLineLengthFixer extends Proxy\ConfigurableFixer
{
    public const NAME = 'Symplify/docblock_line_length';

    protected const ORIGINAL_FIXER_CLASS = OriginalFixer::class;
}
