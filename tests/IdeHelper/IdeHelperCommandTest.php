<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\Tests\IdeHelper;


use Spiral\IdeHelper\IdeHelperCommand;
use Spiral\Tests\BaseTest;

/**
 * Class IdeHelperCommandTest
 *
 * @package Spiral\Tests\IdeHelper
 */
class IdeHelperCommandTest extends BaseTest
{
    public function testNoParams()
    {
        $result = $this->console->run(IdeHelperCommand::NAME);
        $this->assertSame(0, $result->getCode());

        $samplesRoot = self::TESTS_ROOT . '/data/';
        $generatedRoot = directory('runtime') . 'ide-helper/';

        $directory = new \RecursiveDirectoryIterator($samplesRoot);
        $iterator = new \RecursiveIteratorIterator($directory);
        /** @var \SplFileInfo $item */
        foreach ($iterator as $item) {
            if (in_array($item->getFileName(), ['.', '..'])) {
                continue;
            }

            $sampleFile = $item->getPathname();
            $generatedFile = str_replace($samplesRoot, $generatedRoot, $sampleFile);

            $sampleContent = file_get_contents($sampleFile);
            $generatedContent = file_get_contents($generatedFile);

            $this->assertSame($sampleContent, $generatedContent);
        }
    }
}
