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
    public function testExecution()
    {
        $this->console->run(IdeHelperCommand::NAME);
        $this->assertTrue(true);
    }
}