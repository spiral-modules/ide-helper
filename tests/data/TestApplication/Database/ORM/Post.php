<?php
namespace TestApplication\Database\ORM;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $public
 * @property int $user_id
 * @property \TestApplication\Database\ORM\Comment[]|\Spiral\ORM\Entities\Relations\HasManyRelation $comments
 * @property \TestApplication\Database\ORM\Tag[]|\Spiral\ORM\Entities\Relations\HasManyRelation $tags
 * @property \TestApplication\Database\ORM\User|\Spiral\ORM\Entities\Relations\BelongsToRelation $author
 */
class Post
{
}