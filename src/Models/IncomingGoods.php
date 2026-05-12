<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\IncomingGoodsItem;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Geccomedia\Weclapp\SubModels\ShipmentStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $incomingGoodsNumber
 * @property string|null $status
 * @property string|null $warehouseId
 * @property string|null $warehouseName
 * @property string|null $supplierId
 * @property string|null $supplierName
 * @property string|null $purchaseOrderId
 * @property string|null $purchaseOrderNumber
 * @property string|null $responsibleUserId
 * @property string|null $note
 * @property Carbon|null $incomingGoodsDate
 * @property list<IncomingGoodsItem>|null $incomingGoodsItems
 * @property string|null $commercialLanguage
 * @property string|null $creatorId
 * @property list<CustomAttribute>|null $customAttributes
 * @property RecordAddress|null $customerDeliveryAddress
 * @property RecordAddress|null $customerInvoiceAddress
 * @property string|null $deliveryNoteNumber
 * @property string|null $description
 * @property string|null $dhlReceiverId
 * @property bool|null $disableRecordEmailingRule
 * @property string|null $dropshippingShipmentId
 * @property string|null $incomingGoodsType
 * @property RecordAddress|null $invoiceAddress
 * @property string|null $invoiceRecipientId
 * @property list<OnlyId>|null $purchaseOrders
 * @property RecordAddress|null $recipientAddress
 * @property string|null $recordComment
 * @property string|null $recordFreeText
 * @property string|null $recordOpening
 * @property string|null $relatedShipmentId
 * @property RecordAddress|null $returnAddress
 * @property list<OnlyId>|null $salesOrders
 * @property string|null $senderCustomerNumber
 * @property string|null $senderPartyId
 * @property string|null $senderSupplierNumber
 * @property bool|null $sentToRecipient
 * @property string|null $shippingReturnCarrierId
 * @property int|null $shippingReturnLabelsCount
 * @property string|null $sourceWarehouseId
 * @property list<ShipmentStatus>|null $statusHistory
 * @property array|null $tags
 */
class IncomingGoods extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customAttributes' => CustomAttribute::class,
        'customerDeliveryAddress' => RecordAddress::class,
        'customerInvoiceAddress' => RecordAddress::class,
        'incomingGoodsItems' => IncomingGoodsItem::class,
        'invoiceAddress' => RecordAddress::class,
        'purchaseOrders' => OnlyId::class,
        'recipientAddress' => RecordAddress::class,
        'returnAddress' => RecordAddress::class,
        'salesOrders' => OnlyId::class,
        'statusHistory' => ShipmentStatus::class,
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
    public function dropshippingShipment()
    {
        return $this->belongsTo(Shipment::class, 'dropshippingShipmentId');
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
    public function relatedShipment()
    {
        return $this->belongsTo(Shipment::class, 'relatedShipmentId');
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
    public function senderParty()
    {
        return $this->belongsTo(Party::class, 'senderPartyId');
    }

    /**
     * @return BelongsTo
     */
    public function shippingReturnCarrier()
    {
        return $this->belongsTo(ShippingCarrier::class, 'shippingReturnCarrierId');
    }

    /**
     * @return BelongsTo
     */
    public function sourceWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'sourceWarehouseId');
    }

    /**
     * @return BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplierId');
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchaseOrderId');
    }
}
