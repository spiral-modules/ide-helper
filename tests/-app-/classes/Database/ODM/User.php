<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace TestApplication\Database\ODM;


use Spiral\ODM\Document;

/**
 * Class User
 *
 * @package TestApplication\Database
 */
class User extends Document
{
    const SCHEMA = [
        'name' => 'string',
        'tags' => ['string'],

        'primaryAddress' => Address::class,
        'addresses'      => [Address::class]
    ];
}