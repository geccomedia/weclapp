<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $allowOverBooking
 * @property bool|null $allowTimeBooking
 * @property string|null $articleId
 * @property array|null $assignees
 * @property string|null $billableStatus
 * @property string|null $calendarEventId
 * @property string|null $creatorUserId
 * @property array|null $customAttributes
 * @property string|null $customerId
 * @property Carbon|null $dateFrom
 * @property Carbon|null $dateTo
 * @property string|null $description
 * @property array|null $entityReferences
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
 * @property array|null $taskLists
 * @property array|null $taskMailAccount
 * @property string|null $taskPriority
 * @property string|null $taskStatus
 * @property array|null $taskTopics
 * @property array|null $taskTypes
 * @property string|null $taskVisibilityType
 * @property string|null $ticketId
 * @property string|null $userOfLastStatusChangeId
 * @property array|null $watchers
 */
class Task extends Model
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
}
