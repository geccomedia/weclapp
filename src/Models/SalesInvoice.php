<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

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
 * @property array|null $salesInvoiceItems
 * @property array|null $shippingCostItems
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
 * @property array|null $commissionSalesPartners
 * @property bool|null $commissionSettlementDone
 * @property string|null $costCenterId
 * @property string|null $costTypeId
 * @property string|null $creatorId
 * @property bool|null $creditResetsOrderState
 * @property string|null $currencyConversionDate
 * @property bool|null $currencyConversionLocked
 * @property float|null $currencyConversionRate
 * @property array|null $customAttributes
 * @property string|null $customerHabitualExporterLetterOfIntentId
 * @property array|null $deliveryAddress
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
 * @property array|null $recordAddress
 * @property string|null $recordComment
 * @property bool|null $recordCommentInheritance
 * @property string|null $recordCurrencyId
 * @property array|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property bool|null $recordFreeTextInheritance
 * @property string|null $recordOpening
 * @property bool|null $recordOpeningInheritance
 * @property string|null $recurringInvoiceId
 * @property string|null $salesInvoiceType
 * @property string|null $salesOrderId
 * @property array|null $salesOrders
 * @property bool|null $sentToRecipient
 * @property string|null $sepaDirectDebitMandateId
 * @property string|null $shipmentMethodId
 * @property array|null $statusHistory
 * @property array|null $tags
 * @property string|null $vatRegistrationNumber
 */
class SalesInvoice extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<string, string>
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
    ];
}
