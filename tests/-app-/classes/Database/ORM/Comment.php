<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Anton Titov (Wolfy-J)
 * @licence   MIT
 */

namespace TestApplication\Database\ORM;

use Spiral\ORM\Record;

class Comment extends Record
{
    const SCHEMA = [
        'id'      => 'primary',
        'message' => 'string,null',

        'author' => [self::BELONGS_TO => User::class, self::NULLABLE => true]
    ];
}