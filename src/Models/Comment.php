<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

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
class Comment extends Model {}
