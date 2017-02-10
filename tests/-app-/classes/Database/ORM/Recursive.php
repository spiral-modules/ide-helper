<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Anton Titov (Wolfy-J)
 * @licence   MIT
 */

namespace TestApplication\Database\ORM;

use Spiral\ORM\Record;

class Recursive extends Record
{
    const SCHEMA = [
        'id'     => 'bigPrimary',
        'name'   => 'string',
        'parent' => [
            self::BELONGS_TO        => self::class,
            self::NULLABLE          => true,
            self::CREATE_CONSTRAINT => false
        ],
    ];
}