<?php
/**
 * Tokenizer and Class locator component configurations. Attention, configs might include runtime
 * code which depended on environment values only.
 *
 * @see TokenizerConfig
 */
return [
    /*
     * Tokenizer will be performing class and invocation lookup in a following directories. Less
     * directories - faster Tokenizer will work.
     */
    'directories' => [
        directory('application'),

        //Default set of spiral console commands
        directory('libraries') . 'spiral/framework/source/Spiral/Commands/',

        //IdeHelper Module
        directory('root') . '../../source/IdeHelper/',

        /*{{directories}}*/
    ],
    /*
     * Such paths are excluded from tokenization. You can use format compatible with Symfony Finder.
     */
    'exclude'     => [
        'config',
        'resources',
        'migrations',
        /*{{exclude}}*/
    ]
];