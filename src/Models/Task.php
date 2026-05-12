<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

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
class Task extends Model {}
