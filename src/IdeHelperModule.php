<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral;


use Spiral\Core\DirectoriesInterface;
use Spiral\IdeHelper\IdeHelperConfig;
use Spiral\Modules\ModuleInterface;
use Spiral\Modules\PublisherInterface;
use Spiral\Modules\RegistratorInterface;

/**
 * Class IdeHelperModule
 *
 * @package Spiral\IdeHelper
 */
class IdeHelperModule implements ModuleInterface
{
    /**
     * @inheritdoc
     */
    public function register(RegistratorInterface $registrator)
    {
        $registrator->configure('tokenizer', 'directories', 'spiral/idehelper', [
            "directory('libraries') . 'spiral/idehelper/src/',",
        ]);
    }

    /**
     * @inheritdoc
     */
    public function publish(PublisherInterface $publisher, DirectoriesInterface $directories)
    {
        $publisher->publish(
            __DIR__ . '/../resources/config.php',
            $directories->directory('config') . IdeHelperConfig::CONFIG . '.php'
        );
    }
}