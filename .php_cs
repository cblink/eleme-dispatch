<?php
$header = <<<EOF
This file is part of the cblink/eleme-dispatch.

(c) jinjun <757258777@qq.com>

This source file is subject to the MIT license that is bundled.
EOF;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules(array(
        '@Symfony' => true,
        'header_comment' => array('header' => $header),
        'array_syntax' => array('syntax' => 'short'),
        'ordered_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'php_unit_construct' => true,
        'php_unit_strict' => true,
        'no_superfluous_phpdoc_tags' => false,
        'single_trait_insert_per_statement' => false,
    ))
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->in(__DIR__)
    )
;