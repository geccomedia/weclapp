<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\EmailAddresses;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\SubModels\Parcel;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Geccomedia\Weclapp\SubModels\ShipmentItem;
use Geccomedia\Weclapp\SubModels\ShipmentStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $shipmentNumber
 * @property string|null $status
 * @property string|null $warehouseId
 * @property string|null $warehouseName
 * @property string|null $customerId
 * @property string|null $customerName
 * @property string|null $salesOrderId
 * @property string|null $salesOrderNumber
 * @property string|null $responsibleUserId
 * @property string|null $trackingNumber
 * @property string|null $shipmentMethodId
 * @property string|null $shipmentMethodName
 * @property string|null $fulfillmentProviderId
 * @property string|null $note
 * @property Carbon|null $shipmentDate
 * @property list<ShipmentItem>|null $shipmentItems
 * @property string|null $additionalDeliveryInformation
 * @property string|null $commercialLanguage
 * @property string|null $consolidationStoragePlaceId
 * @property string|null $creatorId
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $customerPurchaseOrderNumber
 * @property float|null $declaredValueAmount
 * @property string|null $declaredValueAmountCurrencyId
 * @property string|null $deliveryDate
 * @property string|null $description
 * @property string|null $destinationStoragePlaceId
 * @property string|null $destinationWarehouseId
 * @property string|null $dhlReceiverId
 * @property bool|null $disableRecordEmailingRule
 * @property RecordAddress|null $invoiceAddress
 * @property string|null $invoiceRecipientId
 * @property string|null $mainSalesOrderId
 * @property float|null $packageHeight
 * @property float|null $packageLength
 * @property string|null $packageReferenceNumber
 * @property string|null $packageReturnTrackingNumber
 * @property string|null $packageReturnTrackingUrl
 * @property string|null $packageTrackingNumber
 * @property string|null $packageTrackingUrl
 * @property float|null $packageWeight
 * @property float|null $packageWidth
 * @property list<Parcel>|null $parcels
 * @property string|null $pickingInstructions
 * @property bool|null $picksComplete
 * @property list<OnlyId>|null $purchaseOrders
 * @property RecordAddress|null $recipientAddress
 * @property string|null $recipientCustomerNumber
 * @property string|null $recipientPartyId
 * @property string|null $recipientSupplierNumber
 * @property string|null $recordComment
 * @property EmailAddresses|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property string|null $recordOpening
 * @property EmailAddresses|null $salesInvoiceEmailAddresses
 * @property list<OnlyId>|null $salesOrders
 * @property bool|null $sentToRecipient
 * @property string|null $shipmentType
 * @property RecordAddress|null $shippedFromAddress
 * @property string|null $shippingCarrierId
 * @property string|null $shippingDate
 * @property int|null $shippingLabelsCount
 * @property string|null $shippingReturnCarrierId
 * @property int|null $shippingReturnLabelsCount
 * @property list<ShipmentStatus>|null $statusHistory
 * @property array|null $tags
 * @property float|null $totalWeight
 */
class Shipment extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customAttributes' => CustomAttribute::class,
        'invoiceAddress' => RecordAddress::class,
        'parcels' => Parcel::class,
        'purchaseOrders' => OnlyId::class,
        'recipientAddress' => RecordAddress::class,
        'recordEmailAddresses' => EmailAddresses::class,
        'salesInvoiceEmailAddresses' => EmailAddresses::class,
        'salesOrders' => OnlyId::class,
        'shipmentItems' => ShipmentItem::class,
        'shippedFromAddress' => RecordAddress::class,
        'statusHistory' => ShipmentStatus::class,
    ];

    /**
     * @return BelongsTo
     */
    public function consolidationStoragePlace()
    {
        return $this->belongsTo(StoragePlace::class, 'consolidationStoragePlaceId');
    }

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
    public function declaredValueAmountCurrency()
    {
        return $this->belongsTo(Currency::class, 'declaredValueAmountCurrencyId');
    }

    /**
     * @return BelongsTo
     */
    public function destinationStoragePlace()
    {
        return $this->belongsTo(StoragePlace::class, 'destinationStoragePlaceId');
    }

    /**
     * @return BelongsTo
     */
    public function destinationWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'destinationWarehouseId');
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
    public function mainSalesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'mainSalesOrderId');
    }

    /**
     * @return BelongsTo
     */
    public function recipientParty()
    {
        return $this->belongsTo(Party::class, 'recipientPartyId');
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
    public function shipmentMethod()
    {
        return $this->belongsTo(ShipmentMethod::class, 'shipmentMethodId');
    }

    /**
     * @return BelongsTo
     */
    public function shippingCarrier()
    {
        return $this->belongsTo(ShippingCarrier::class, 'shippingCarrierId');
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
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customerId');
    }

    public function salesOrder(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class, 'salesOrderId');
    }

    public function fulfillmentProvider(): BelongsTo
    {
        return $this->belongsTo(FulfillmentProvider::class, 'fulfillmentProviderId');
    }

    /**
     * POST /createPickingList
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPickingList(array $params = []): ?array
    {
        return $this->newQuery()->callAction('createPickingList', $params, 'POST');
    }

    /**
     * POST /createPickingOrder
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPickingOrder(array $params = []): ?array
    {
        return $this->newQuery()->callAction('createPickingOrder', $params, 'POST');
    }

    /**
     * POST /createReturnLabels
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createReturnLabels(array $params = []): ?array
    {
        return $this->newQuery()->callAction('createReturnLabels', $params, 'POST');
    }

    /**
     * POST /createSalesInvoice
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createSalesInvoice(array $params = []): ?array
    {
        return $this->newQuery()->callAction('createSalesInvoice', $params, 'POST');
    }

    /**
     * POST /createShippingLabelPdf
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createShippingLabelPdf(array $params = []): ?array
    {
        return $this->newQuery()->callAction('createShippingLabelPdf', $params, 'POST');
    }

    /**
     * POST /createShippingLabels
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createShippingLabels(array $params = []): ?array
    {
        return $this->newQuery()->callAction('createShippingLabels', $params, 'POST');
    }

    /**
     * GET /downloadLatestDeliveryNotePdf
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadLatestDeliveryNotePdf(array $params = []): ?array
    {
        return $this->newQuery()->callAction('downloadLatestDeliveryNotePdf', $params, 'GET');
    }

    /**
     * GET /downloadLatestPickingListPdf
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadLatestPickingListPdf(array $params = []): ?array
    {
        return $this->newQuery()->callAction('downloadLatestPickingListPdf', $params, 'GET');
    }

    /**
     * GET /downloadLatestShippingLabelPdf
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadLatestShippingLabelPdf(array $params = []): ?array
    {
        return $this->newQuery()->callAction('downloadLatestShippingLabelPdf', $params, 'GET');
    }

    /**
     * POST /printLabel
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function printLabel(array $params = []): ?array
    {
        return $this->newQuery()->callAction('printLabel', $params, 'POST');
    }
}
