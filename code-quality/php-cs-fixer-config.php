<?php

return PhpCsFixer\Config::create()
    ->setCacheFile(__DIR__ . '/php-cs-fixer.cache')
    ->setRiskyAllowed(true)
    ->setRules(Suin\PhpCsFixer\Rules::create())
    ->setFinder(PhpCsFixer\Finder::create()
        ->exclude('vendor')
        ->in('packages')
    )
    ;
