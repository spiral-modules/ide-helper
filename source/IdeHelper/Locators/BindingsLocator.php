<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper\Locators;

use Spiral\Core\Traits\SharedTrait;
use Spiral\IdeHelper\Model\ClassDefinition;
use Spiral\IdeHelper\Scanners\BindingsScanner;
use Spiral\Tokenizer\ClassesInterface;

/**
 * Class BindingsLocator
 *
 * @package Spiral\IdeHelper\Locators
 */
class BindingsLocator implements LocatorInterface
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
     * BindingsHelper constructor.
     *
     * @param ClassesInterface $classes
     * @param BindingsScanner  $scanner
     */
    public function __construct(ClassesInterface $classes, BindingsScanner $scanner)
    {
        $this->classes = $classes;
        $this->scanner = $scanner;
    }

    /**
     * @return ClassDefinition[]
     */
    public function locate(): array
    {
        $bindings = $this->scanner->scan();
        $classNames = array_keys($this->classes->getClasses(SharedTrait::class));

        $classes = [];
        foreach ($classNames as $className) {
            $classes[] = new ClassDefinition($className, $bindings);
        }

        return $classes;
    }
}
