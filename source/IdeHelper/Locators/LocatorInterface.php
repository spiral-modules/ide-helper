<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper\Locators;

use Spiral\IdeHelper\Model\ClassDefinition;

/**
 * Interface LocatorInterface
 *
 * @package Spiral\IdeHelper\Locators
 */
interface LocatorInterface
{
    /**
     * @return ClassDefinition[]
     */
    public function locate(): array;
}
