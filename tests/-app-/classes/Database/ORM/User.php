<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Anton Titov (Wolfy-J)
 * @licence   MIT
 */

namespace TestApplication\Database\ORM;

use Spiral\ORM\Record;

/**
 * @property int     $id
 * @property string  $name
 * @property string  $status
 * @property Post[]  $posts
 * @property Profile $profile
 */
class User extends Record
{
    //nothing is secured
    const SECURED = [];

    const SCHEMA = [
        'id'      => 'primary',
        'name'    => 'string',
        'status'  => 'enum(active, disabled)',
        'balance' => 'float',

        //Relations
        'posts'   => [
            self::HAS_MANY          => Post::class,
            Post::INVERSE           => 'author',
            Post::NULLABLE          => false,
            self::CREATE_CONSTRAINT => false
        ],

        'profile' => [self::HAS_ONE => Profile::class]
    ];

    const DEFAULTS = [
        'name'   => null,
        'status' => 'active'
    ];

    const INDEXES = [
        [self::INDEX, 'status']
    ];
}