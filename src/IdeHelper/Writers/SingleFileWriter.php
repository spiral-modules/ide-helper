<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper\Writers;

use Spiral\Files\FilesInterface;
use Spiral\IdeHelper\Renderer\RendererInterface;

/**
 * Class SingleFileWriter
 *
 * @package Spiral\IdeHelper\Writers
 */
class SingleFileWriter implements WriterInterface
{
    /**
     * @var FilesInterface
     */
    private $files;

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var string
     */
    private $outputFile;

    /**
     * SingleFileWriter constructor.
     *
     * @param FilesInterface    $files
     * @param RendererInterface $renderer
     * @param string            $outputFile
     */
    public function __construct(
        FilesInterface $files,
        RendererInterface $renderer,
        string $outputFile
    ) {
        $this->files = $files;
        $this->renderer = $renderer;
        $this->outputFile = $outputFile;
    }

    /**
     * @inheritDoc
     */
    public function write(array $classes)
    {
        $directory = pathinfo($this->outputFile, PATHINFO_DIRNAME);
        $this->files->ensureDirectory($directory);

        $content = $this->renderer->render($classes);

        $this->files->write($this->outputFile, $content);
    }
}
