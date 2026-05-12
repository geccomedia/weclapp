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
}
