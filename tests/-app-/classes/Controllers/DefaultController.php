<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace TestApplication\Controllers;


use Spiral\Core\Controller;

/**
 * Class DefaultController
 *
 * @package TestApplication\Controllers
 */
class DefaultController extends Controller
{
    /**
     * @return string
     */
    public function helloAction(): string
    {
        return 'Hello world!';
    }
}