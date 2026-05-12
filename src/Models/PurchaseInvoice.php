<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property Carbon|null $bookingDate
 * @property string|null $bookingText
 * @property Carbon|null $cancellationDate
 * @property string|null $commercialLanguage
 * @property string|null $costCenterId
 * @property string|null $costTypeId
 * @property bool|null $createdViaOcr
 * @property string|null $creatorId
 * @property bool|null $creditResetsOrderState
 * @property Carbon|null $currencyConversionDate
 * @property bool|null $currencyConversionLocked
 * @property float|null $currencyConversionRate
 * @property array|null $customAttributes
 * @property array|null $deliveryAddress
 * @property Carbon|null $deliveryDate
 * @property string|null $description
 * @property bool|null $disableRecordEmailingRule
 * @property Carbon|null $dueDate
 * @property float|null $grossAmount
 * @property float|null $grossAmountInCompanyCurrency
 * @property float|null $grossAmountOfHeaderTaxes
 * @property float|null $grossAmountOfHeaderTaxesInCompanyCurrency
 * @property bool|null $grossPrices
 * @property float|null $headerDiscount
 * @property float|null $headerSurcharge
 * @property float|null $importSalesTaxAmount
 * @property string|null $importSalesTaxId
 * @property string|null $internalInvoiceNumber
 * @property array|null $invoiceAddress
 * @property Carbon|null $invoiceDate
 * @property string|null $invoiceNumber
 * @property float|null $netAmount
 * @property float|null $netAmountInCompanyCurrency
 * @property string|null $nonStandardTaxId
 * @property bool|null $paymentBlock
 * @property string|null $paymentBlockNote
 * @property string|null $paymentMethodId
 * @property string|null $paymentStatus
 * @property string|null $precedingPurchaseInvoiceId
 * @property Carbon|null $pricingDate
 * @property array|null $purchaseInvoiceItems
 * @property string|null $purchaseInvoiceType
 * @property array|null $purchaseOrders
 * @property string|null $recipientCountryCode
 * @property array|null $recordAddress
 * @property string|null $recordComment
 * @property string|null $recordCurrencyId
 * @property array|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property string|null $recordOpening
 * @property string|null $responsibleUserId
 * @property string|null $senderCountryCode
 * @property bool|null $sentToRecipient
 * @property Carbon|null $servicePeriodFrom
 * @property Carbon|null $servicePeriodTo
 * @property array|null $shippingCostItems
 * @property Carbon|null $shippingDate
 * @property string|null $status
 * @property array|null $statusHistory
 * @property string|null $supplierHabitualExporterLetterOfIntentId
 * @property string|null $supplierId
 * @property array|null $tags
 * @property string|null $termOfPaymentId
 * @property string|null $vatRegistrationNumber
 */
class PurchaseInvoice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchaseInvoice';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'bookingDate' => 'datetime',
        'cancellationDate' => 'datetime',
        'createdDate' => 'datetime',
        'currencyConversionDate' => 'datetime',
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
