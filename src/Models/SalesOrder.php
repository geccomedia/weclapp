<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CommissionSalesPartner;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\EcommerceOrder;
use Geccomedia\Weclapp\SubModels\EmailAddresses;
use Geccomedia\Weclapp\SubModels\ProjectMembers;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Geccomedia\Weclapp\SubModels\SalesOrderItem;
use Geccomedia\Weclapp\SubModels\SalesOrderPayment;
use Geccomedia\Weclapp\SubModels\SalesOrderShippingCostItem;
use Geccomedia\Weclapp\SubModels\SalesOrderStatusHistory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string|null $salesOrderNumber
 * @property string|null $status
 * @property string|null $customerId
 * @property string|null $customerNumber
 * @property string|null $salesChannel
 * @property string|null $responsibleUserId
 * @property string|null $responsibleUserUsername
 * @property string|null $currencyId
 * @property string|null $currencyName
 * @property string|null $paymentMethodId
 * @property string|null $paymentMethodName
 * @property string|null $termOfPaymentId
 * @property string|null $termOfPaymentName
 * @property string|null $shippingAddressId
 * @property string|null $invoiceAddressId
 * @property string|null $warehouseId
 * @property string|null $warehouseName
 * @property string|null $shipmentMethodId
 * @property string|null $shipmentMethodName
 * @property string|null $note
 * @property string|null $internalNote
 * @property float|null $grossAmount
 * @property float|null $netAmount
 * @property float|null $openAmount
 * @property Carbon|null $orderDate
 * @property Carbon|null $deliveryDate
 * @property Carbon|null $pricingDate
 * @property Carbon|null $serviceDate
 * @property list<SalesOrderItem>|null $orderItems
 * @property array|null $salesOrderPaymentInfos
 * @property float|null $advancePaymentAmount
 * @property string|null $advancePaymentStatus
 * @property bool|null $applyShippingCostsOnlyOnce
 * @property string|null $cashAccountId
 * @property string|null $commercialLanguage
 * @property float|null $commission
 * @property list<CommissionSalesPartner>|null $commissionSalesPartners
 * @property string|null $creatorId
 * @property string|null $currencyConversionDate
 * @property bool|null $currencyConversionLocked
 * @property float|null $currencyConversionRate
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $customerHabitualExporterLetterOfIntentId
 * @property string|null $defaultShippingCarrierId
 * @property string|null $defaultShippingReturnCarrierId
 * @property RecordAddress|null $deliveryAddress
 * @property EmailAddresses|null $deliveryEmailAddresses
 * @property string|null $description
 * @property bool|null $disableRecordEmailingRule
 * @property string|null $dispatchCountryCode
 * @property EcommerceOrder|null $ecommerceOrder
 * @property bool|null $factoring
 * @property string|null $fulfillmentProviderId
 * @property float|null $grossAmountInCompanyCurrency
 * @property float|null $headerDiscount
 * @property float|null $headerSurcharge
 * @property RecordAddress|null $invoiceAddress
 * @property string|null $invoiceRecipientId
 * @property bool|null $invoiced
 * @property float|null $netAmountInCompanyCurrency
 * @property string|null $nonStandardTaxId
 * @property bool|null $onlyServices
 * @property string|null $orderNumber
 * @property string|null $orderNumberAtCustomer
 * @property bool|null $paid
 * @property list<SalesOrderPayment>|null $payments
 * @property string|null $plannedDeliveryDate
 * @property string|null $plannedProjectEndDate
 * @property string|null $plannedProjectStartDate
 * @property string|null $plannedShippingDate
 * @property string|null $projectGoals
 * @property list<ProjectMembers>|null $projectMembers
 * @property bool|null $projectModeActive
 * @property string|null $quotationId
 * @property RecordAddress|null $recordAddress
 * @property string|null $recordAsn
 * @property string|null $recordComment
 * @property bool|null $recordCommentInheritance
 * @property string|null $recordCurrencyId
 * @property EmailAddresses|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property bool|null $recordFreeTextInheritance
 * @property string|null $recordOpening
 * @property bool|null $recordOpeningInheritance
 * @property EmailAddresses|null $salesInvoiceEmailAddresses
 * @property string|null $salesOrderPaymentType
 * @property bool|null $sentToRecipient
 * @property string|null $sepaDirectDebitMandateId
 * @property string|null $servicePeriodFrom
 * @property string|null $servicePeriodTo
 * @property bool|null $servicesFinished
 * @property bool|null $shipped
 * @property list<SalesOrderShippingCostItem>|null $shippingCostItems
 * @property int|null $shippingLabelsCount
 * @property list<SalesOrderStatusHistory>|null $statusHistory
 * @property array|null $tags
 * @property bool|null $template
 */
class SalesOrder extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'commissionSalesPartners' => CommissionSalesPartner::class,
        'customAttributes' => CustomAttribute::class,
        'deliveryAddress' => RecordAddress::class,
        'deliveryEmailAddresses' => EmailAddresses::class,
        'ecommerceOrder' => EcommerceOrder::class,
        'invoiceAddress' => RecordAddress::class,
        'orderItems' => SalesOrderItem::class,
        'payments' => SalesOrderPayment::class,
        'projectMembers' => ProjectMembers::class,
        'recordAddress' => RecordAddress::class,
        'recordEmailAddresses' => EmailAddresses::class,
        'salesInvoiceEmailAddresses' => EmailAddresses::class,
        'shippingCostItems' => SalesOrderShippingCostItem::class,
        'statusHistory' => SalesOrderStatusHistory::class,
    ];

    /**
     * @return BelongsTo
     */
    public function cashAccount()
    {
        return $this->belongsTo(CashAccount::class, 'cashAccountId');
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
    public function customer()
    {
        return $this->belongsTo(Party::class, 'customerId');
    }

    /**
     * @return BelongsTo
     */
    public function defaultShippingCarrier()
    {
        return $this->belongsTo(ShippingCarrier::class, 'defaultShippingCarrierId');
    }

    /**
     * @return BelongsTo
     */
    public function defaultShippingReturnCarrier()
    {
        return $this->belongsTo(ShippingCarrier::class, 'defaultShippingReturnCarrierId');
    }

    /**
     * @return BelongsTo
     */
    public function fulfillmentProvider()
    {
        return $this->belongsTo(FulfillmentProvider::class, 'fulfillmentProviderId');
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
    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotationId');
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
    public function sepaDirectDebitMandate()
    {
        return $this->belongsTo(SepaDirectDebitMandate::class, 'sepaDirectDebitMandateId');
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

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class, 'salesOrderId');
    }

    public function salesInvoices(): HasMany
    {
        return $this->hasMany(SalesInvoice::class, 'salesOrderId');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currencyId');
    }

    /**
     * POST /activateProjectView
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function activateProjectView(array $params = []): ?array
    {
        return $this->callAction('activateProjectView', $params, 'POST');
    }

    /**
     * POST /calculateSalesPrices
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function calculateSalesPrices(array $params = []): ?array
    {
        return $this->callAction('calculateSalesPrices', $params, 'POST');
    }

    /**
     * POST /cancelOrManuallyClose
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function cancelOrManuallyClose(array $params = []): ?array
    {
        return $this->callAction('cancelOrManuallyClose', $params, 'POST');
    }

    /**
     * POST /createAdvancePaymentRequest
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createAdvancePaymentRequest(array $params = []): ?array
    {
        return $this->callAction('createAdvancePaymentRequest', $params, 'POST');
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
     * POST /createCustomerReturn
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createCustomerReturn(array $params = []): ?array
    {
        return $this->callAction('createCustomerReturn', $params, 'POST');
    }

    /**
     * POST /createDropshipping
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createDropshipping(array $params = []): ?array
    {
        return $this->callAction('createDropshipping', $params, 'POST');
    }

    /**
     * POST /createPartPaymentInvoice
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPartPaymentInvoice(array $params = []): ?array
    {
        return $this->callAction('createPartPaymentInvoice', $params, 'POST');
    }

    /**
     * POST /createPerformanceRecord
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPerformanceRecord(array $params = []): ?array
    {
        return $this->callAction('createPerformanceRecord', $params, 'POST');
    }

    /**
     * POST /createPrepaymentFinalInvoice
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPrepaymentFinalInvoice(array $params = []): ?array
    {
        return $this->callAction('createPrepaymentFinalInvoice', $params, 'POST');
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
     * POST /createPurchaseOrder
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPurchaseOrder(array $params = []): ?array
    {
        return $this->callAction('createPurchaseOrder', $params, 'POST');
    }

    /**
     * POST /createPurchaseOrderRequest
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPurchaseOrderRequest(array $params = []): ?array
    {
        return $this->callAction('createPurchaseOrderRequest', $params, 'POST');
    }

    /**
     * POST /createReturnLabels
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createReturnLabels(array $params = []): ?array
    {
        return $this->callAction('createReturnLabels', $params, 'POST');
    }

    /**
     * POST /createSalesInvoice
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createSalesInvoice(array $params = []): ?array
    {
        return $this->callAction('createSalesInvoice', $params, 'POST');
    }

    /**
     * POST /createShipment
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createShipment(array $params = []): ?array
    {
        return $this->callAction('createShipment', $params, 'POST');
    }

    /**
     * POST /createShippingLabels
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createShippingLabels(array $params = []): ?array
    {
        return $this->callAction('createShippingLabels', $params, 'POST');
    }

    /**
     * GET /downloadLatestOrderConfirmationPdf
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadLatestOrderConfirmationPdf(array $params = []): ?array
    {
        return $this->callAction('downloadLatestOrderConfirmationPdf', $params, 'GET');
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

    /**
     * GET /previewSalesOrderConfirmation
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function previewSalesOrderConfirmation(array $params = []): ?array
    {
        return $this->callAction('previewSalesOrderConfirmation', $params, 'GET');
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
     * GET /printOrderData
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function printOrderData(array $params = []): ?array
    {
        return $this->callAction('printOrderData', $params, 'GET');
    }

    /**
     * POST /recalculateCosts
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function recalculateCosts(array $params = []): ?array
    {
        return $this->callAction('recalculateCosts', $params, 'POST');
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
     * POST /setCostsForItemsWithoutCost
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function setCostsForItemsWithoutCost(array $params = []): ?array
    {
        return $this->callAction('setCostsForItemsWithoutCost', $params, 'POST');
    }

    /**
     * POST /shipOrderForExternalFulfillment
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function shipOrderForExternalFulfillment(array $params = []): ?array
    {
        return $this->callAction('shipOrderForExternalFulfillment', $params, 'POST');
    }

    /**
     * POST /toggleProjectTeam
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function toggleProjectTeam(array $params = []): ?array
    {
        return $this->callAction('toggleProjectTeam', $params, 'POST');
    }

    /**
     * POST /toggleServicesFinished
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function toggleServicesFinished(array $params = []): ?array
    {
        return $this->callAction('toggleServicesFinished', $params, 'POST');
    }

    /**
     * POST /updatePrices
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function updatePrices(array $params = []): ?array
    {
        return $this->callAction('updatePrices', $params, 'POST');
    }

    /**
     * GET /defaultValuesForCreate
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function defaultValuesForCreate(array $params = []): ?array
    {
        return $this->callAction('defaultValuesForCreate', $params, 'GET');
    }
}
