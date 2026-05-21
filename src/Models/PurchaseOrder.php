<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\DropshippingDeliveryNoteFormTextBlockData;
use Geccomedia\Weclapp\SubModels\EmailAddresses;
use Geccomedia\Weclapp\SubModels\PurchaseOrderItem;
use Geccomedia\Weclapp\SubModels\PurchaseOrderShippingCostItem;
use Geccomedia\Weclapp\SubModels\PurchaseOrderStatusHistory;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $purchaseOrderNumber
 * @property string|null $status
 * @property string|null $supplierId
 * @property string|null $supplierName
 * @property string|null $responsibleUserId
 * @property string|null $responsibleUserUsername
 * @property string|null $currencyId
 * @property string|null $currencyName
 * @property string|null $paymentMethodId
 * @property string|null $termOfPaymentId
 * @property string|null $warehouseId
 * @property string|null $note
 * @property float|null $grossAmount
 * @property float|null $netAmount
 * @property Carbon|null $orderDate
 * @property Carbon|null $deliveryDate
 * @property list<PurchaseOrderItem>|null $purchaseOrderItems
 * @property string|null $advancePaymentStatus
 * @property string|null $commercialLanguage
 * @property string|null $commercialLanguageCustomer
 * @property float|null $commission
 * @property string|null $confirmationNumber
 * @property string|null $creatorId
 * @property string|null $currencyConversionDate
 * @property bool|null $currencyConversionLocked
 * @property float|null $currencyConversionRate
 * @property list<CustomAttribute>|null $customAttributes
 * @property RecordAddress|null $deliveryAddress
 * @property string|null $description
 * @property bool|null $disableRecordEmailingRule
 * @property DropshippingDeliveryNoteFormTextBlockData|null $dropshippingDeliveryNoteFormTexts
 * @property string|null $externalPurchaseOrderNumber
 * @property bool|null $formSettingsFromSalesChannel
 * @property float|null $grossAmountInCompanyCurrency
 * @property float|null $headerDiscount
 * @property float|null $headerSurcharge
 * @property bool|null $includeCashDiscountInValuationPrice
 * @property RecordAddress|null $invoiceAddress
 * @property bool|null $invoiced
 * @property string|null $mergedToPurchaseOrderId
 * @property float|null $netAmountInCompanyCurrency
 * @property string|null $nonStandardTaxId
 * @property string|null $packageTrackingNumber
 * @property string|null $packageTrackingUrl
 * @property bool|null $paid
 * @property string|null $plannedDeliveryDate
 * @property string|null $plannedShippingDate
 * @property string|null $purchaseOrderRequestId
 * @property string|null $purchaseOrderType
 * @property bool|null $received
 * @property string|null $recipientCountryCode
 * @property RecordAddress|null $recordAddress
 * @property string|null $recordComment
 * @property string|null $recordCurrencyId
 * @property EmailAddresses|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property string|null $recordOpening
 * @property string|null $salesOrderId
 * @property string|null $senderCountryCode
 * @property bool|null $sentToRecipient
 * @property string|null $servicePeriodFrom
 * @property string|null $servicePeriodTo
 * @property string|null $shipmentMethodId
 * @property string|null $shippingCarrierId
 * @property list<PurchaseOrderShippingCostItem>|null $shippingCostItems
 * @property string|null $shippingNotificationDate
 * @property list<PurchaseOrderStatusHistory>|null $statusHistory
 * @property string|null $supplierHabitualExporterLetterOfIntentId
 * @property string|null $supplierQuotationNumber
 * @property array|null $tags
 */
class PurchaseOrder extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customAttributes' => CustomAttribute::class,
        'deliveryAddress' => RecordAddress::class,
        'dropshippingDeliveryNoteFormTexts' => DropshippingDeliveryNoteFormTextBlockData::class,
        'invoiceAddress' => RecordAddress::class,
        'purchaseOrderItems' => PurchaseOrderItem::class,
        'recordAddress' => RecordAddress::class,
        'recordEmailAddresses' => EmailAddresses::class,
        'shippingCostItems' => PurchaseOrderShippingCostItem::class,
        'statusHistory' => PurchaseOrderStatusHistory::class,
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
    public function mergedToPurchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'mergedToPurchaseOrderId');
    }

    /**
     * @return BelongsTo
     */
    public function nonStandardTax()
    {
        return $this->belongsTo(Tax::class, 'nonStandardTaxId');
    }

    /**
     * @return BelongsTo
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'paymentMethodId');
    }

    /**
     * @return BelongsTo
     */
    public function purchaseOrderRequest()
    {
        return $this->belongsTo(PurchaseOrderRequest::class, 'purchaseOrderRequestId');
    }

    /**
     * @return BelongsTo
     */
    public function recordCurrency()
    {
        return $this->belongsTo(Currency::class, 'recordCurrencyId');
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
    public function supplier()
    {
        return $this->belongsTo(Party::class, 'supplierId');
    }

    /**
     * @return BelongsTo
     */
    public function termOfPayment()
    {
        return $this->belongsTo(TermOfPayment::class, 'termOfPaymentId');
    }

    /**
     * @return BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currencyId');
    }

    /**
     * POST /cancelDropshippingShipments
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function cancelDropshippingShipments(array $params = []): ?array
    {
        return $this->callAction('cancelDropshippingShipments', $params, 'POST');
    }

    /**
     * POST /createCancellationSlipPdf
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createCancellationSlipPdf(array $params = []): ?array
    {
        return $this->callAction('createCancellationSlipPdf', $params, 'POST');
    }

    /**
     * POST /createContract
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createContract(array $params = []): ?array
    {
        return $this->callAction('createContract', $params, 'POST');
    }

    /**
     * POST /createDropshippingDeliveryNotePdf
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createDropshippingDeliveryNotePdf(array $params = []): ?array
    {
        return $this->callAction('createDropshippingDeliveryNotePdf', $params, 'POST');
    }

    /**
     * POST /createIncomingGoods
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createIncomingGoods(array $params = []): ?array
    {
        return $this->callAction('createIncomingGoods', $params, 'POST');
    }

    /**
     * POST /createProductionOrders
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createProductionOrders(array $params = []): ?array
    {
        return $this->callAction('createProductionOrders', $params, 'POST');
    }

    /**
     * POST /createPurchaseInvoice
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPurchaseInvoice(array $params = []): ?array
    {
        return $this->callAction('createPurchaseInvoice', $params, 'POST');
    }

    /**
     * POST /createSupplierReturn
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createSupplierReturn(array $params = []): ?array
    {
        return $this->callAction('createSupplierReturn', $params, 'POST');
    }

    /**
     * GET /downloadLatestCancellationSlipPdf
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadLatestCancellationSlipPdf(array $params = []): ?array
    {
        return $this->callAction('downloadLatestCancellationSlipPdf', $params, 'GET');
    }

    /**
     * GET /downloadLatestDropshippingDeliveryNotePdf
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadLatestDropshippingDeliveryNotePdf(array $params = []): ?array
    {
        return $this->callAction('downloadLatestDropshippingDeliveryNotePdf', $params, 'GET');
    }

    /**
     * GET /downloadLatestPurchaseOrderPdf
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadLatestPurchaseOrderPdf(array $params = []): ?array
    {
        return $this->callAction('downloadLatestPurchaseOrderPdf', $params, 'GET');
    }

    /**
     * POST /printLabel
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function printLabel(array $params = []): ?array
    {
        return $this->callAction('printLabel', $params, 'POST');
    }

    /**
     * POST /processDropshipping
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function processDropshipping(array $params = []): ?array
    {
        return $this->callAction('processDropshipping', $params, 'POST');
    }

    /**
     * POST /resetTaxes
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function resetTaxes(array $params = []): ?array
    {
        return $this->callAction('resetTaxes', $params, 'POST');
    }

    /**
     * POST /manuallyClose
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function manuallyClose(array $params = []): ?array
    {
        return $this->callAction('manuallyClose', $params, 'POST');
    }
}
