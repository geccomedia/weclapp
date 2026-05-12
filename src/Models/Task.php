<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\EntityReference;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\SubModels\TaskAssignee;
use Geccomedia\Weclapp\SubModels\TaskMailAccount;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $allowOverBooking
 * @property bool|null $allowTimeBooking
 * @property string|null $articleId
 * @property list<TaskAssignee>|null $assignees
 * @property string|null $billableStatus
 * @property string|null $calendarEventId
 * @property string|null $creatorUserId
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $customerId
 * @property Carbon|null $dateFrom
 * @property Carbon|null $dateTo
 * @property string|null $description
 * @property list<EntityReference>|null $entityReferences
 * @property string|null $identifier
 * @property string|null $invoicingStatus
 * @property Carbon|null $lastReminderDateForOverdue
 * @property string|null $orderItemId
 * @property string|null $parentTaskId
 * @property string|null $performanceRecordedStatus
 * @property float|null $plannedEffort
 * @property int|null $positionNumber
 * @property string|null $previousTaskId
 * @property string|null $subject
 * @property list<OnlyId>|null $taskLists
 * @property TaskMailAccount|null $taskMailAccount
 * @property string|null $taskPriority
 * @property string|null $taskStatus
 * @property list<OnlyId>|null $taskTopics
 * @property list<OnlyId>|null $taskTypes
 * @property string|null $taskVisibilityType
 * @property string|null $ticketId
 * @property string|null $userOfLastStatusChangeId
 * @property list<OnlyId>|null $watchers
 */
class Task extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'assignees' => TaskAssignee::class,
        'customAttributes' => CustomAttribute::class,
        'entityReferences' => EntityReference::class,
        'taskLists' => OnlyId::class,
        'taskMailAccount' => TaskMailAccount::class,
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
    public function calendarEvent()
    {
        return $this->belongsTo(CalendarEvent::class, 'calendarEventId');
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
    public function customer()
    {
        return $this->belongsTo(Party::class, 'customerId');
    }

    /**
     * @return BelongsTo
     */
    public function parentTask()
    {
        return $this->belongsTo(Task::class, 'parentTaskId');
    }

    /**
     * @return BelongsTo
     */
    public function previousTask()
    {
        return $this->belongsTo(Task::class, 'previousTaskId');
    }

    /**
     * @return BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticketId');
    }

    /**
     * @return BelongsTo
     */
    public function userOfLastStatusChange()
    {
        return $this->belongsTo(User::class, 'userOfLastStatusChangeId');
    }

    /**
     * POST /createPerformanceRecord
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPerformanceRecord(array $params = []): ?array
    {
        return $this->newQuery()->callAction('createPerformanceRecord', $params, 'POST');
    }

    /**
     * POST /updateBillingData
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function updateBillingData(array $params = []): ?array
    {
        return $this->newQuery()->callAction('updateBillingData', $params, 'POST');
    }

    /**
     * GET /fromTemplate
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public static function fromTemplate(array $params = []): ?array
    {
        return (new self)->newQuery()->action('fromTemplate', $params, 'GET');
    }
}
