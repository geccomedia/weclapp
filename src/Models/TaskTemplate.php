<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleId
 * @property array|null $assignees
 * @property string|null $creatorUserId
 * @property array|null $customAttributes
 * @property string|null $description
 * @property array|null $entityReferences
 * @property string|null $name
 * @property string|null $parentTaskTemplateId
 * @property float|null $plannedEffort
 * @property int|null $positionNumber
 * @property string|null $subject
 * @property string|null $taskPriority
 * @property array|null $taskTopics
 * @property array|null $taskTypes
 * @property string|null $taskVisibilityType
 * @property array|null $watchers
 */
class TaskTemplate extends Model
{
    /**
     * @return BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'articleId');
    }

    /**
     * @return BelongsTo
     */
    public function creatorUser()
    {
        return $this->belongsTo(User::class, 'creatorUserId');
    }

    /**
     * @return BelongsTo
     */
    public function parentTaskTemplate()
    {
        return $this->belongsTo(TaskTemplate::class, 'parentTaskTemplateId');
    }
}
