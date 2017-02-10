<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Anton Titov (Wolfy-J)
 * @licence   MIT
 */

namespace TestApplication\Database\ORM;

use Spiral\ORM\Record;

class Tag extends Record
{
    const SCHEMA = [
        'id'   => 'primary',
        'name' => 'string(32)'
    ];
}