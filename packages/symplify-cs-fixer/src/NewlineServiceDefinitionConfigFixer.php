<?php

declare(strict_types=1);

namespace SymplifyCsFixer;

use Symplify\CodingStandard\Fixer\Spacing\NewlineServiceDefinitionConfigFixer as OriginalFixer;

final class NewlineServiceDefinitionConfigFixer extends Proxy\FixerProxy
{
    public const NAME = 'Symplify/newline_service_definition_config';

    protected const ORIGINAL_FIXER_CLASS = OriginalFixer::class;
}
