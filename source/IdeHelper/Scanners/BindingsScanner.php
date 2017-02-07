<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper\Scanners;

use Spiral\Core\Container;
use Spiral\IdeHelper\Model\ClassMember;
use Spiral\IdeHelper\Model\ClassProperty;

/**
 * Class BindingsScanner
 *
 * @package Spiral\IdeHelper\Scanners
 */
class BindingsScanner
{
    /**
     * @var Container
     */
    private $container;

    /**
     * BindingsScanner constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return ClassMember[]
     */
    public function scan(): array
    {
        $properties = [];
        $bindings = $this->container->getBindings();

        foreach ($bindings as $name => $resolver) {
            // skip complex things. complex things are bad.
            if (is_array($resolver)) {
                continue;
            }

            // skip if it's not looks like a short binding
            if (lcfirst($name) !== $name || strpos($name, '\\')) {
                continue;
            }

            // skip if target class doesn't exists
            if (!class_exists($resolver) && !interface_exists($resolver)) {
                continue;
            }

            $properties[] = new ClassProperty($name, $resolver);
        }

        return $properties;
    }
}
