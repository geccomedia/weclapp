<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\PurchaseOrderRequestItem;
use Geccomedia\Weclapp\SubModels\PurchaseOrderRequestOffer;
use Geccomedia\Weclapp\SubModels\PurchaseOrderRequestStatusHistory;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $commercialLanguage
 * @property float|null $commission
 * @property Carbon|null $confirmationDeadline
 * @property string|null $creatorId
 * @property list<CustomAttribute>|null $customAttributes
 * @property RecordAddress|null $deliveryAddress
 * @property string|null $description
 * @property bool|null $disableRecordEmailingRule
 * @property RecordAddress|null $invoiceAddress
 * @property Carbon|null $plannedDeliveryDate
 * @property list<PurchaseOrderRequestItem>|null $purchaseOrderRequestItems
 * @property string|null $purchaseOrderRequestNumber
 * @property list<PurchaseOrderRequestOffer>|null $purchaseOrderRequestOffers
 * @property string|null $purchaseOrderRequestType
 * @property string|null $quotationId
 * @property RecordAddress|null $recordAddress
 * @property string|null $recordComment
 * @property string|null $recordFreeText
 * @property string|null $recordOpening
 * @property string|null $responsibleUserId
 * @property string|null $salesOrderId
 * @property bool|null $sentToRecipient
 * @property string|null $status
 * @property list<PurchaseOrderRequestStatusHistory>|null $statusHistory
 * @property array|null $tags
 * @property string|null $warehouseId
 */
class PurchaseOrderRequest extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customAttributes' => CustomAttribute::class,
        'deliveryAddress' => RecordAddress::class,
        'invoiceAddress' => RecordAddress::class,
        'purchaseOrderRequestItems' => PurchaseOrderRequestItem::class,
        'purchaseOrderRequestOffers' => PurchaseOrderRequestOffer::class,
        'recordAddress' => RecordAddress::class,
        'statusHistory' => PurchaseOrderRequestStatusHistory::class,
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
    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotationId');
    }

    /**
     * @return BelongsTo
     */
    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsibleUserId');
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
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }
}
