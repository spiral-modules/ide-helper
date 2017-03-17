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

/**
 * Class PhpstormMetaRenderer
 *
 * @package Spiral\IdeHelper\Renderer
 */
class PhpstormMetaRenderer implements RendererInterface
{
    /**
     * @var string
     */
    private $method;

    /**
     * PhpstormMetaRenderer constructor.
     *
     * @param string $method
     */
    public function __construct(string $method = 'get')
    {
        $this->method = $method;
    }

    /**
     * @inheritdoc
     */
    public function render(array $classes): string
    {
        $content = '<?php' . PHP_EOL;
        $content .= 'namespace PHPSTORM_META {' . PHP_EOL;

        foreach ($classes as $class) {
            $target = $class->getName();
            $content .= "override(\\{$target}(0), map([" . PHP_EOL;
            foreach ($class->getMembers() as $member) {
                if ($member instanceof ClassProperty) {
                    $name = $member->getName();
                    $type = Helpers::fqcn($member->getTypes()[0]);

                    $content .= "'{$name}' => {$type}::class," . PHP_EOL;
                }
            }
            $content .= "]));" . PHP_EOL;
        }

        $content .= "}" . PHP_EOL;

        return $content;
    }
}
