<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Anton Titov (Wolfy-J)
 * @licence   MIT
 */

namespace TestApplication\Database\ORM;

use Spiral\ORM\Record;

class Profile extends Record
{
    const SCHEMA = [
        'id'  => 'bigPrimary',
        'bio' => 'text'
    ];
}