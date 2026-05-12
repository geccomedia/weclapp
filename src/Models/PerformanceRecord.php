<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $commercialLanguage
 * @property float|null $commission
 * @property string|null $creatorId
 * @property array|null $customAttributes
 * @property string|null $customerId
 * @property Carbon|null $customerSignatureDate
 * @property string|null $description
 * @property bool|null $disableRecordEmailingRule
 * @property array|null $invoiceAddress
 * @property string|null $invoiceRecipientId
 * @property string|null $orderNumberAtCustomer
 * @property Carbon|null $performanceRecordDate
 * @property array|null $performanceRecordItems
 * @property string|null $performanceRecordNumber
 * @property array|null $recordAddress
 * @property string|null $recordComment
 * @property bool|null $recordCommentInheritance
 * @property array|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property bool|null $recordFreeTextInheritance
 * @property string|null $recordOpening
 * @property bool|null $recordOpeningInheritance
 * @property string|null $salesChannel
 * @property array|null $salesInvoiceEmailAddresses
 * @property string|null $salesOrderId
 * @property bool|null $sentToRecipient
 * @property Carbon|null $servicePeriodFrom
 * @property Carbon|null $servicePeriodTo
 * @property string|null $serviceProviderId
 * @property Carbon|null $serviceProviderSignatureDate
 * @property string|null $status
 * @property array|null $statusHistory
 * @property array|null $tags
 */
class PerformanceRecord extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'performanceRecord';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'createdDate' => 'datetime',
        'customerSignatureDate' => 'datetime',
        'lastModifiedDate' => 'datetime',
        'performanceRecordDate' => 'datetime',
        'servicePeriodFrom' => 'datetime',
        'servicePeriodTo' => 'datetime',
        'serviceProviderSignatureDate' => 'datetime',
    ];
}
