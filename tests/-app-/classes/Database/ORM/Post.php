<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Anton Titov (Wolfy-J)
 * @licence   MIT
 */

namespace TestApplication\Database\ORM;

use Spiral\ORM\Record;

class Post extends Record
{
    const SCHEMA = [
        'id'      => 'bigPrimary',
        'title'   => 'string(64)',
        'content' => 'text',
        'public'  => 'bool',

        'comments' => [
            self::HAS_MANY   => Comment::class,
            Comment::INVERSE => 'post'
        ],

        'tags' => [
            self::MANY_TO_MANY  => Tag::class,
            self::PIVOT_COLUMNS => ['time_linked' => 'datetime'],
            Tag::INVERSE        => 'posts'
        ]
    ];
}