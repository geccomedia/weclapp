<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $articleId
 * @property bool|null $billable
 * @property int|null $billableDurationSeconds
 * @property string|null $billableInvoiceStatus
 * @property array|null $customAttributes
 * @property string|null $customerId
 * @property string|null $description
 * @property int|null $durationSeconds
 * @property string|null $externalConnectionSourceId
 * @property float|null $hourlyRate
 * @property string|null $performanceRecordedStatus
 * @property string|null $placeOfServiceId
 * @property bool|null $printOnPerformanceRecord
 * @property string|null $projectId
 * @property string|null $projectTaskId
 * @property string|null $salesInvoiceId
 * @property string|null $salesOrderId
 * @property string|null $salesOrderTicketId
 * @property string|null $serviceQuotaId
 * @property Carbon|null $startDate
 * @property string|null $taskId
 * @property string|null $ticketId
 * @property string|null $timeRecordSource
 * @property string|null $userId
 */
class TimeRecord extends Model {}
