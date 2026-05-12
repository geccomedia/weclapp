<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $text
 * @property string|null $entityName
 * @property string|null $entityId
 * @property string|null $createdByUserId
 * @property string|null $createdByUserUsername
 * @property bool|null $pinned
 * @property string|null $authorName
 * @property string|null $authorUserId
 * @property string|null $comment
 * @property string|null $htmlComment
 * @property string|null $lastEditDate
 * @property string|null $parentCommentId
 * @property bool|null $privateComment
 * @property bool|null $publicComment
 * @property array|null $recipientUsers
 * @property bool|null $solution
 */
class Comment extends Model
{
    /**
     * @return BelongsTo
     */
    public function authorUser()
    {
        return $this->belongsTo(User::class, 'authorUserId');
    }

    /**
     * @return BelongsTo
     */
    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'parentCommentId');
    }
}
