<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\EmailAddresses;
use Geccomedia\Weclapp\SubModels\PerformanceRecordItem;
use Geccomedia\Weclapp\SubModels\PerformanceRecordStatusHistory;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $commercialLanguage
 * @property float|null $commission
 * @property string|null $creatorId
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $customerId
 * @property Carbon|null $customerSignatureDate
 * @property string|null $description
 * @property bool|null $disableRecordEmailingRule
 * @property RecordAddress|null $invoiceAddress
 * @property string|null $invoiceRecipientId
 * @property string|null $orderNumberAtCustomer
 * @property Carbon|null $performanceRecordDate
 * @property list<PerformanceRecordItem>|null $performanceRecordItems
 * @property string|null $performanceRecordNumber
 * @property RecordAddress|null $recordAddress
 * @property string|null $recordComment
 * @property bool|null $recordCommentInheritance
 * @property EmailAddresses|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property bool|null $recordFreeTextInheritance
 * @property string|null $recordOpening
 * @property bool|null $recordOpeningInheritance
 * @property string|null $salesChannel
 * @property EmailAddresses|null $salesInvoiceEmailAddresses
 * @property string|null $salesOrderId
 * @property bool|null $sentToRecipient
 * @property Carbon|null $servicePeriodFrom
 * @property Carbon|null $servicePeriodTo
 * @property string|null $serviceProviderId
 * @property Carbon|null $serviceProviderSignatureDate
 * @property string|null $status
 * @property list<PerformanceRecordStatusHistory>|null $statusHistory
 * @property array|null $tags
 */
class PerformanceRecord extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'createdDate' => 'datetime',
        'customerSignatureDate' => 'datetime',
        'lastModifiedDate' => 'datetime',
        'performanceRecordDate' => 'datetime',
        'servicePeriodFrom' => 'datetime',
        'servicePeriodTo' => 'datetime',
        'serviceProviderSignatureDate' => 'datetime',
        'customAttributes' => CustomAttribute::class,
        'invoiceAddress' => RecordAddress::class,
        'performanceRecordItems' => PerformanceRecordItem::class,
        'recordAddress' => RecordAddress::class,
        'recordEmailAddresses' => EmailAddresses::class,
        'salesInvoiceEmailAddresses' => EmailAddresses::class,
        'statusHistory' => PerformanceRecordStatusHistory::class,
    ];

    /**
     * @return BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorId');
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
    public function invoiceRecipient()
    {
        return $this->belongsTo(Party::class, 'invoiceRecipientId');
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
    public function serviceProvider()
    {
        return $this->belongsTo(User::class, 'serviceProviderId');
    }

    /**
     * POST /addToPerformanceRecord
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function addToPerformanceRecord(array $params = []): ?array
    {
        return $this->newQuery()->callAction('addToPerformanceRecord', $params, 'POST');
    }

    /**
     * POST /createInvoice
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createInvoice(array $params = []): ?array
    {
        return $this->newQuery()->callAction('createInvoice', $params, 'POST');
    }

    /**
     * GET /downloadLatestPerformanceRecordPdf
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadLatestPerformanceRecordPdf(array $params = []): ?array
    {
        return $this->newQuery()->callAction('downloadLatestPerformanceRecordPdf', $params, 'GET');
    }

    /**
     * GET /downloadSignature
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadSignature(array $params = []): ?array
    {
        return $this->newQuery()->callAction('downloadSignature', $params, 'GET');
    }

    /**
     * POST /performServiceQuotaAssignmentForTimeRecords
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function performServiceQuotaAssignmentForTimeRecords(array $params = []): ?array
    {
        return $this->newQuery()->callAction('performServiceQuotaAssignmentForTimeRecords', $params, 'POST');
    }

    /**
     * POST /recalculateQuantities
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function recalculateQuantities(array $params = []): ?array
    {
        return $this->newQuery()->callAction('recalculateQuantities', $params, 'POST');
    }

    /**
     * POST /removeSignature
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function removeSignature(array $params = []): ?array
    {
        return $this->newQuery()->callAction('removeSignature', $params, 'POST');
    }

    /**
     * POST /uploadSignature
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function uploadSignature(array $params = []): ?array
    {
        return $this->newQuery()->callAction('uploadSignature', $params, 'POST');
    }

    /**
     * POST /startConfiguredMassPerformanceRecordCreation
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public static function startConfiguredMassPerformanceRecordCreation(array $params = []): ?array
    {
        return (new self)->newQuery()->action('startConfiguredMassPerformanceRecordCreation', $params, 'POST');
    }
}
