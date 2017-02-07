<?php

use Spiral\IdeHelper\Locators;
use Spiral\IdeHelper\Writers;
use Spiral\IdeHelper\Renderer;

return [
    // locators are responsible for searching classes and their members
    'locators' => [
        'containers' => bind(Locators\ContainersLocator::class, [
            'targets' => [
                \Interop\Container\ContainerInterface::class . '::get',
                'spiral',
            ],
        ]),
        'bindings'   => Locators\BindingsLocator::class,
        'documents'  => Locators\DocumentsLocator::class,
        'requests'   => Locators\RequestsLocator::class,
        'records'    => Locators\RecordsLocator::class,
    ],
    // writers are responsible for storing data collected by locators
    'writers'  => [
        'phpProperty' => bind(Writers\FilePerClassWriter::class, [
            'outputDirectory' => directory('root') . 'resources/Virtual/',
            'renderer'        => bind(Renderer\ReactorBasedPropertyRenderer::class),
        ]),
        'phpDoc' => bind(Writers\FilePerClassWriter::class, [
            'outputDirectory' => directory('root') . 'resources/Virtual/',
            'renderer'        => bind(Renderer\ReactorBasedDocRenderer::class),
        ]),
        'meta'    => bind(Writers\SingleFileWriter::class, [
            'outputFile' => directory('root') . '.phpstorm.meta.php/virtual.meta.php',
            'renderer'   => bind(Renderer\PhpstormMetaRenderer::class),
        ]),
    ],
    // each scope is a combination of locators and writers, first each locator is executed to
    // collect data, then each writer is executed with all collected data
    'scopes'   => [
        'container' => [
            'locators' => ['bindings'],
            'writers'  => ['phpProperty'],
        ],
        'entity' => [
            'locators' => ['documents', 'requests', 'records'],
            'writers'  => ['phpDoc'],
        ],
        'meta'    => [
            'locators' => ['containers'],
            'writers'  => ['meta'],
        ],
    ],
];
