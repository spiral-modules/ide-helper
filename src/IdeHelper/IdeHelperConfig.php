<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper;

use Spiral\Core\InjectableConfig;

/**
 * Class IdeHelperConfig
 *
 * @package Spiral\IdeHelper
 */
class IdeHelperConfig extends InjectableConfig
{
    const CONFIG = 'modules/ide-helper';

    /**
     * @var array
     */
    protected $config = [
        'writers'      => [],
        'locators'     => [],
        'scopes'       => [],
    ];

    /**
     * @return array
     */
    public function getWriters(): array
    {
        return $this->config['writers'];
    }

    /**
     * @return array
     */
    public function getLocators(): array
    {
        return $this->config['locators'];
    }

    /**
     * @return array
     */
    public function getScopes(): array
    {
        return $this->config['scopes'];
    }
}
