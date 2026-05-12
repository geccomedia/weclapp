<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\EntityReference;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\SubModels\TaskTemplateAssignee;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleId
 * @property list<TaskTemplateAssignee>|null $assignees
 * @property string|null $creatorUserId
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $description
 * @property list<EntityReference>|null $entityReferences
 * @property string|null $name
 * @property string|null $parentTaskTemplateId
 * @property float|null $plannedEffort
 * @property int|null $positionNumber
 * @property string|null $subject
 * @property string|null $taskPriority
 * @property list<OnlyId>|null $taskTopics
 * @property list<OnlyId>|null $taskTypes
 * @property string|null $taskVisibilityType
 * @property list<OnlyId>|null $watchers
 */
class TaskTemplate extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'assignees' => TaskTemplateAssignee::class,
        'customAttributes' => CustomAttribute::class,
        'entityReferences' => EntityReference::class,
        'taskTopics' => OnlyId::class,
        'taskTypes' => OnlyId::class,
        'watchers' => OnlyId::class,
    ];

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
