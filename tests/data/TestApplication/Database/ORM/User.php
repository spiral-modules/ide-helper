<?php
namespace TestApplication\Database\ORM;

/**
 * @property int $id
 * @property string|null $name
 * @property string $status
 * @property float $balance
 * @property \TestApplication\Database\ORM\Post[]|\Spiral\ORM\Entities\Relations\HasManyRelation $posts
 * @property \TestApplication\Database\ORM\Profile|\Spiral\ORM\Entities\Relations\HasOneRelation $profile
 */
class User
{
}