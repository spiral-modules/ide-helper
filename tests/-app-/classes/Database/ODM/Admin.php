<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace TestApplication\Database\ODM;


/**
 * Class Admin
 *
 * @package TestApplication\Database
 */
class Admin extends User
{
    const SCHEMA = [
        'password' => 'string'
    ];
}