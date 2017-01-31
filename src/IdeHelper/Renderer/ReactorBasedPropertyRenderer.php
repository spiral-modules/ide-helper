<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper\Renderer;

use Spiral\IdeHelper\Helpers;
use Spiral\IdeHelper\Model\ClassProperty;
use Spiral\Reactor\ClassDeclaration;
use Spiral\Reactor\ClassDeclaration\PropertyDeclaration;
use Spiral\Reactor\FileDeclaration;


/**
 * Class ReactorBasedPropertyRenderer
 *
 * WARNING: this class only support rendering multiple classes in the same namespace.
 *
 * @package Spiral\IdeHelper\Renderer
 */
class ReactorBasedPropertyRenderer implements RendererInterface
{
    /**
     * @inheritdoc
     */
    public function render(array $classes): string
    {
        if (count($classes) === 0) {
            $declaration = new FileDeclaration();

            return $declaration->render();
        }

        $namespace = $classes[0]->getNamespace() ?? '';
        $fileDeclaration = new FileDeclaration($namespace);
        foreach ($classes as $class) {
            $classDeclaration = new ClassDeclaration($class->getShortName());
            $properties = $classDeclaration->getProperties();

            foreach ($class->getMembers() as $member) {
                if ($member instanceof ClassProperty) {
                    $name = $member->getName();
                    $comment = $this->renderProperty($member->getTypes());

                    $property = new PropertyDeclaration($name, null, $comment);
                    $property->setAccess("protected");

                    $properties->add($property);
                }
            }

            $fileDeclaration->addElement($classDeclaration);
        }

        return $fileDeclaration->render();
    }

    /**
     * @param array $types
     * @return string
     */
    private function renderProperty(array $types): string
    {
        $type = implode('|', array_map([Helpers::class, 'fqcn'], $types));

        return "@var {$type}";
    }
}