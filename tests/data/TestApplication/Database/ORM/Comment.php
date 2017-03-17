<?php
namespace TestApplication\Database\ORM;

/**
 * @property int $id
 * @property string|null $message
 * @property int|null $author_id
 * @property int|null $post_id
 * @property \TestApplication\Database\ORM\User|\Spiral\ORM\Entities\Relations\BelongsToRelation|null $author
 * @property \TestApplication\Database\ORM\Post|\Spiral\ORM\Entities\Relations\BelongsToRelation|null $post
 */
class Comment
{
}