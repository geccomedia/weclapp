<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CommissionSalesPartner;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\EmailAddresses;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Geccomedia\Weclapp\SubModels\SalesInvoiceItem;
use Geccomedia\Weclapp\SubModels\SalesInvoiceShippingCostItem;
use Geccomedia\Weclapp\SubModels\SalesInvoiceStatusHistory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $invoiceNumber
 * @property string|null $status
 * @property string|null $customerId
 * @property string|null $customerNumber
 * @property string|null $salesChannel
 * @property string|null $responsibleUserId
 * @property string|null $currencyId
 * @property string|null $currencyName
 * @property string|null $paymentMethodId
 * @property string|null $paymentMethodName
 * @property string|null $termOfPaymentId
 * @property string|null $termOfPaymentName
 * @property string|null $shippingAddressId
 * @property string|null $note
 * @property float|null $grossAmount
 * @property float|null $netAmount
 * @property float|null $openAmount
 * @property float|null $taxAmount
 * @property float|null $shippingCostAmount
 * @property Carbon|null $invoiceDate
 * @property Carbon|null $deliveryDate
 * @property Carbon|null $dueDate
 * @property Carbon|null $pricingDate
 * @property Carbon|null $servicePeriodFrom
 * @property Carbon|null $servicePeriodTo
 * @property Carbon|null $shippingDate
 * @property list<SalesInvoiceItem>|null $salesInvoiceItems
 * @property list<SalesInvoiceShippingCostItem>|null $shippingCostItems
 * @property array|null $salesInvoiceTaxAmounts
 * @property string|null $bookingDate
 * @property string|null $bookingText
 * @property string|null $cancellationDate
 * @property string|null $cancellationNumber
 * @property bool|null $cancellationSlipCommissionBlock
 * @property bool|null $cancellationSlipCommissionSettlementDone
 * @property string|null $collectiveInvoicePositionPrintType
 * @property string|null $commercialLanguage
 * @property float|null $commission
 * @property bool|null $commissionBlock
 * @property list<CommissionSalesPartner>|null $commissionSalesPartners
 * @property bool|null $commissionSettlementDone
 * @property string|null $costCenterId
 * @property string|null $costTypeId
 * @property string|null $creatorId
 * @property bool|null $creditResetsOrderState
 * @property string|null $currencyConversionDate
 * @property bool|null $currencyConversionLocked
 * @property float|null $currencyConversionRate
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $customerHabitualExporterLetterOfIntentId
 * @property RecordAddress|null $deliveryAddress
 * @property string|null $description
 * @property bool|null $directDebitFileCreated
 * @property string|null $directDebitFileLatestDate
 * @property bool|null $disableRecordEmailingRule
 * @property string|null $dispatchCountryCode
 * @property string|null $dunningBlockDateUntilDate
 * @property string|null $dunningBlockNote
 * @property string|null $dunningBlockState
 * @property string|null $epcQrCodeReference
 * @property bool|null $factoring
 * @property float|null $grossAmountInCompanyCurrency
 * @property float|null $headerDiscount
 * @property float|null $headerSurcharge
 * @property float|null $netAmountInCompanyCurrency
 * @property string|null $nonStandardTaxId
 * @property string|null $orderNumberAtCustomer
 * @property bool|null $paid
 * @property string|null $paymentStatus
 * @property string|null $precedingSalesInvoiceId
 * @property string|null $quotationId
 * @property RecordAddress|null $recordAddress
 * @property string|null $recordComment
 * @property bool|null $recordCommentInheritance
 * @property string|null $recordCurrencyId
 * @property EmailAddresses|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property bool|null $recordFreeTextInheritance
 * @property string|null $recordOpening
 * @property bool|null $recordOpeningInheritance
 * @property string|null $recurringInvoiceId
 * @property string|null $salesInvoiceType
 * @property string|null $salesOrderId
 * @property list<OnlyId>|null $salesOrders
 * @property bool|null $sentToRecipient
 * @property string|null $sepaDirectDebitMandateId
 * @property string|null $shipmentMethodId
 * @property list<SalesInvoiceStatusHistory>|null $statusHistory
 * @property array|null $tags
 * @property string|null $vatRegistrationNumber
 */
class SalesInvoice extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'createdDate' => 'datetime',
        'deliveryDate' => 'datetime',
        'dueDate' => 'datetime',
        'invoiceDate' => 'datetime',
        'lastModifiedDate' => 'datetime',
        'pricingDate' => 'datetime',
        'servicePeriodFrom' => 'datetime',
        'servicePeriodTo' => 'datetime',
        'shippingDate' => 'datetime',
        'commissionSalesPartners' => CommissionSalesPartner::class,
        'customAttributes' => CustomAttribute::class,
        'deliveryAddress' => RecordAddress::class,
        'recordAddress' => RecordAddress::class,
        'recordEmailAddresses' => EmailAddresses::class,
        'salesInvoiceItems' => SalesInvoiceItem::class,
        'salesOrders' => OnlyId::class,
        'shippingCostItems' => SalesInvoiceShippingCostItem::class,
        'statusHistory' => SalesInvoiceStatusHistory::class,
    ];

    /**
     * @return BelongsTo
     */
    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'costCenterId');
    }

    /**
     * @return BelongsTo
     */
    public function costType()
    {
        return $this->belongsTo(CostType::class, 'costTypeId');
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
    public function precedingSalesInvoice()
    {
        return $this->belongsTo(SalesInvoice::class, 'precedingSalesInvoiceId');
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
    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'salesOrderId');
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
}
