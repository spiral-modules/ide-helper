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
use Spiral\Reactor\FileDeclaration;

/**
 * Class ReactorBasedDocRenderer
 *
 * WARNING: this class only support rendering multiple classes in the same namespace.
 *
 * @package Spiral\IdeHelper\Renderer
 */
class ReactorBasedDocRenderer implements RendererInterface
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

            foreach ($class->getMembers() as $member) {
                if ($member instanceof ClassProperty) {
                    $classDeclaration->getComment()->addLine($this->renderProperty($member));
                }
            }

            $fileDeclaration->addElement($classDeclaration);
        }

        return $fileDeclaration->render();
    }

    /**
     * @param ClassProperty $property
     * @return string
     */
    private function renderProperty(ClassProperty $property): string
    {
        $type = implode('|', array_map([Helpers::class, 'fqcn'], $property->getTypes()));

        return "@property {$type} \${$property->getName()}";
    }
}
