<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper\Writers;

use Psr\Log\LoggerInterface;
use Spiral\Files\FilesInterface;
use Spiral\IdeHelper\Model\ClassDefinition;
use Spiral\IdeHelper\Renderer\RendererInterface;

/**
 * Class ClassesWriter
 *
 * @package Spiral\IdeHelper
 */
class FilePerClassWriter implements WriterInterface
{
    /**
     * @var FilesInterface
     */
    private $files;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $outputDirectory;

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * ClassWriter constructor.
     *
     * @param FilesInterface    $files
     * @param LoggerInterface   $logger
     * @param RendererInterface $renderer
     * @param string            $outputDirectory
     */
    public function __construct(
        FilesInterface $files,
        LoggerInterface $logger,
        RendererInterface $renderer,
        string $outputDirectory
    ) {
        $this->files = $files;
        $this->logger = $logger;
        $this->renderer = $renderer;
        $this->outputDirectory = $outputDirectory;
    }

    /**
     * @param ClassDefinition[] $classes
     */
    public function write(array $classes)
    {
        foreach ($classes as $class) {
            $directory = $this->outputDirectory . $class->getNamespace();
            $directory = $this->files->normalizePath($directory);
            $filename = $directory . '/' . $class->getShortName() . '.php';
            $filename = $this->files->normalizePath($filename);

            $this->files->ensureDirectory($directory);
            $this->files->write($filename, $this->renderer->render([$class]));

            $this->logger->info("Create $filename file.");
        }
    }
}
