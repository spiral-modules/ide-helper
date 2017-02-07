<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper\Writers;

use Spiral\IdeHelper\Model\ClassDefinition;

/**
 * Interface WriterInterface
 *
 * @package Spiral\IdeHelper\Writers
 */
interface WriterInterface
{
    /**
     * @param ClassDefinition[] $classes
     */
    public function write(array $classes);
}
