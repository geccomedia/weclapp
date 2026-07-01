<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\EmailAddresses;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\SubModels\PurchaseInvoiceItem;
use Geccomedia\Weclapp\SubModels\PurchaseInvoiceShippingCostItem;
use Geccomedia\Weclapp\SubModels\PurchaseInvoiceStatusHistory;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property list<CustomAttribute>|null $customAttributes
 * @property RecordAddress|null $deliveryAddress
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
 * @property RecordAddress|null $invoiceAddress
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
 * @property list<PurchaseInvoiceItem>|null $purchaseInvoiceItems
 * @property string|null $purchaseInvoiceType
 * @property list<OnlyId>|null $purchaseOrders
 * @property string|null $recipientCountryCode
 * @property RecordAddress|null $recordAddress
 * @property string|null $recordComment
 * @property string|null $recordCurrencyId
 * @property EmailAddresses|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property string|null $recordOpening
 * @property string|null $responsibleUserId
 * @property string|null $senderCountryCode
 * @property bool|null $sentToRecipient
 * @property Carbon|null $servicePeriodFrom
 * @property Carbon|null $servicePeriodTo
 * @property list<PurchaseInvoiceShippingCostItem>|null $shippingCostItems
 * @property Carbon|null $shippingDate
 * @property string|null $status
 * @property list<PurchaseInvoiceStatusHistory>|null $statusHistory
 * @property string|null $supplierHabitualExporterLetterOfIntentId
 * @property string|null $supplierId
 * @property array|null $tags
 * @property string|null $termOfPaymentId
 * @property string|null $vatRegistrationNumber
 */
class PurchaseInvoice extends Model
{
    /**
     * @var array<string, class-string|string>
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
        'customAttributes' => CustomAttribute::class,
        'deliveryAddress' => RecordAddress::class,
        'invoiceAddress' => RecordAddress::class,
        'purchaseInvoiceItems' => PurchaseInvoiceItem::class,
        'purchaseOrders' => OnlyId::class,
        'recordAddress' => RecordAddress::class,
        'recordEmailAddresses' => EmailAddresses::class,
        'shippingCostItems' => PurchaseInvoiceShippingCostItem::class,
        'statusHistory' => PurchaseInvoiceStatusHistory::class,
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
    public function importSalesTax()
    {
        return $this->belongsTo(Tax::class, 'importSalesTaxId');
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
    public function precedingPurchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class, 'precedingPurchaseInvoiceId');
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
     * POST /cancel
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function cancel(array $params = []): ?array
    {
        return $this->callAction('cancel', $params, 'POST');
    }

    /**
     * POST /convertPurchaseInvoiceToCreditNote
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function convertPurchaseInvoiceToCreditNote(array $params = []): ?array
    {
        return $this->callAction('convertPurchaseInvoiceToCreditNote', $params, 'POST');
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
     * POST /createCreditNote
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createCreditNote(array $params = []): ?array
    {
        return $this->callAction('createCreditNote', $params, 'POST');
    }

    /**
     * GET /downloadLatestPurchaseInvoiceDocument
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadLatestPurchaseInvoiceDocument(array $params = []): ?array
    {
        return $this->callAction('downloadLatestPurchaseInvoiceDocument', $params, 'GET');
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
     * POST /saveDuplicateInvoiceAsOriginal
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function saveDuplicateInvoiceAsOriginal(array $params = []): ?array
    {
        return $this->callAction('saveDuplicateInvoiceAsOriginal', $params, 'POST');
    }

    /**
     * POST /startInvoiceDocumentProcessing
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function startInvoiceDocumentProcessing(array $params = []): ?array
    {
        return $this->callAction('startInvoiceDocumentProcessing', $params, 'POST');
    }

    /**
     * POST /updateStatus
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function updateStatus(array $params = []): ?array
    {
        return $this->callAction('updateStatus', $params, 'POST');
    }
}
