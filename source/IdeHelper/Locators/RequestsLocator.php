<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper\Locators;

use Psr\Http\Message\UploadedFileInterface;
use Spiral\Http\Request\RequestFilter;
use Spiral\IdeHelper\Model\ClassDefinition;
use Spiral\IdeHelper\Model\ClassProperty;
use Spiral\Models\Reflections\ReflectionEntity;
use Spiral\Tokenizer\ClassesInterface;

/**
 * Class RequestsLocator
 *
 * @package Spiral\IdeHelper\Locators
 */
class RequestsLocator implements LocatorInterface
{
    /**
     * @var ClassesInterface
     */
    private $classes;

    /**
     * RequestsLocator constructor.
     *
     * @param ClassesInterface $classes
     */
    public function __construct(ClassesInterface $classes)
    {
        $this->classes = $classes;
    }

    /**
     * @inheritdoc
     */
    public function locate(): array
    {
        $classes = [];
        $classNames = array_keys($this->classes->getClasses(RequestFilter::class));

        foreach ($classNames as $className) {
            $members = $this->scan($className);
            $classes[] = new ClassDefinition($className, $members);
        }

        return $classes;
    }

    /**
     * @param string $class
     * @return array
     */
    private function scan(string $class): array
    {
        $properties = [];

        $r = new ReflectionEntity($class);

        foreach ($r->getSchema() as $field => $definition) {
            $type = 'mixed';

            if ($this->isClass($definition)) {
                $type = $definition;
            } elseif ($this->isTypedArray($definition)) {
                $type = $definition[0] . '[]';
            } elseif (0 === strpos($definition, 'file:')) {
                $type = UploadedFileInterface::class;
            }

            $properties[] = new ClassProperty($field, $type);
        }

        return $properties;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function isClass($value): bool
    {
        return is_string($value) && class_exists($value);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function isTypedArray($value): bool
    {
        return is_array($value) && count($value) > 0 && $this->isClass($value[0]);
    }
}
