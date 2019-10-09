<?php

/**
 * This configuration will be read and overlaid on top of the
 * default configuration. Command line arguments will be applied
 * after this file is read.
 */
return [

    "target_php_version" => '7.3',
    'directory_list' => [
        'src',
        'vendor/symfony/dom-crawler',
        'vendor/guzzlehttp/guzzle',
        'vendor/psr/http-message'
    ],
    "exclude_analysis_directory_list" => [
        'vendor/'
    ],
    'plugins' => [
        // checks if a function, closure or method unconditionally returns.

        // can also be written as 'vendor/phan/phan/.phan/plugins/AlwaysReturnPlugin.php'
        'AlwaysReturnPlugin',
        // Checks for syntactically unreachable statements in
        // the global scope or function bodies.
        'UnreachableCodePlugin',
        'DollarDollarPlugin',
        'DuplicateArrayKeyPlugin',
        'PregRegexCheckerPlugin',
        'PrintfCheckerPlugin',
    ],
];