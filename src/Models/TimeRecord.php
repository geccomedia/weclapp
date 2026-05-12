<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleId
 * @property bool|null $billable
 * @property int|null $billableDurationSeconds
 * @property string|null $billableInvoiceStatus
 * @property list<CustomAttribute>|null $customAttributes
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
class TimeRecord extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customAttributes' => CustomAttribute::class,
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
    public function customer()
    {
        return $this->belongsTo(Party::class, 'customerId');
    }

    /**
     * @return BelongsTo
     */
    public function salesInvoice()
    {
        return $this->belongsTo(SalesInvoice::class, 'salesInvoiceId');
    }

    /**
     * @return BelongsTo
     */
    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'salesOrderId');
    }

    /**
     * @return BelongsTo
     */
    public function salesOrderTicket()
    {
        return $this->belongsTo(Ticket::class, 'salesOrderTicketId');
    }

    /**
     * @return BelongsTo
     */
    public function serviceQuota()
    {
        return $this->belongsTo(ServiceQuota::class, 'serviceQuotaId');
    }

    /**
     * @return BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'taskId');
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
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
