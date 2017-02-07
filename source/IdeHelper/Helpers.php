<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper;

/**
 * Class Helpers
 *
 * @package Spiral\IdeHelper
 */
class Helpers
{
    /**
     * Return fully qualified class name. Support "typed arrays" syntax.
     *
     * @param string $name
     * @return string
     */
    public static function fqcn(string $name): string
    {
        $type = str_replace('[]', '', $name);

        if (class_exists($type) || interface_exists($type) && '\\' !== $type[0]) {
            return '\\' . $name;
        }

        return $name;
    }
}
