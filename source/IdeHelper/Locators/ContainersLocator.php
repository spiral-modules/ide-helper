<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper\Locators;

use Spiral\IdeHelper\Model\ClassDefinition;
use Spiral\IdeHelper\Scanners\BindingsScanner;
use Spiral\Tokenizer\ClassesInterface;

/**
 * Class ContainersLocator
 *
 * @package Spiral\IdeHelper\Locators
 */
class ContainersLocator implements LocatorInterface
{
    /**
     * @var ClassesInterface
     */
    private $classes;

    /**
     * @var BindingsScanner
     */
    private $scanner;

    /**
     * @var string[]
     */
    private $targets;

    /**
     * ContainersLocator constructor.
     *
     * @param ClassesInterface $classes
     * @param BindingsScanner  $scanner
     * @param array            $targets
     */
    public function __construct(ClassesInterface $classes, BindingsScanner $scanner, array $targets)
    {
        $this->classes = $classes;
        $this->scanner = $scanner;
        $this->targets = $targets;
    }

    /**
     * @inheritdoc
     */
    public function locate(): array
    {
        $bindings = $this->scanner->scan();

        $results = [];
        foreach ($this->targets as $target) {
            $results[] = new ClassDefinition($target, $bindings);
        }
        return $results;
    }
}
