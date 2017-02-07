<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper\Renderer;

use Spiral\IdeHelper\Model\ClassDefinition;

/**
 * Interface RendererInterface
 *
 * @package Spiral\IdeHelper\Renderer
 */
interface RendererInterface
{
    /**
     * @param ClassDefinition[] $classes
     * @return string
     */
    public function render(array $classes): string;
}
