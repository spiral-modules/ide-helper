<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace TestApplication\Database\ODM;


use Spiral\ODM\DocumentEntity;

/**
 * Class Address
 *
 * @package TestApplication\Database
 */
class Address extends DocumentEntity
{
    const SCHEMA = [
        'country' => 'string',
        'city'    => 'string',
        'address' => 'string'
    ];
}