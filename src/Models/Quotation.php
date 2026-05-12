<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CommissionSalesPartner;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\EmailAddresses;
use Geccomedia\Weclapp\SubModels\QuotationItem;
use Geccomedia\Weclapp\SubModels\QuotationShippingCostItem;
use Geccomedia\Weclapp\SubModels\QuotationStatusHistory;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Geccomedia\Weclapp\SubModels\SalesStageHistory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $quotationNumber
 * @property string|null $status
 * @property string|null $customerId
 * @property string|null $customerNumber
 * @property string|null $salesChannel
 * @property string|null $responsibleUserId
 * @property string|null $currencyId
 * @property string|null $currencyName
 * @property string|null $paymentMethodId
 * @property string|null $termOfPaymentId
 * @property string|null $note
 * @property float|null $grossAmount
 * @property float|null $netAmount
 * @property Carbon|null $quotationDate
 * @property Carbon|null $validUntilDate
 * @property list<QuotationItem>|null $quotationItems
 * @property bool|null $activeVersion
 * @property string|null $commercialLanguage
 * @property float|null $commission
 * @property list<CommissionSalesPartner>|null $commissionSalesPartners
 * @property string|null $creatorId
 * @property string|null $currencyConversionDate
 * @property bool|null $currencyConversionLocked
 * @property float|null $currencyConversionRate
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $defaultShippingCarrierId
 * @property RecordAddress|null $deliveryAddress
 * @property EmailAddresses|null $deliveryEmailAddresses
 * @property string|null $description
 * @property bool|null $disableRecordEmailingRule
 * @property string|null $dispatchCountryCode
 * @property string|null $expectedSignatureDate
 * @property bool|null $factoring
 * @property float|null $grossAmountInCompanyCurrency
 * @property float|null $headerDiscount
 * @property float|null $headerSurcharge
 * @property RecordAddress|null $invoiceAddress
 * @property string|null $invoiceRecipientId
 * @property string|null $mergedToQuotationId
 * @property float|null $netAmountInCompanyCurrency
 * @property string|null $nonStandardTaxId
 * @property string|null $opportunityId
 * @property string|null $plannedDeliveryDate
 * @property string|null $plannedShippingDate
 * @property string|null $pricingDate
 * @property string|null $publicLink
 * @property string|null $quotationType
 * @property int|null $quotationVersion
 * @property RecordAddress|null $recordAddress
 * @property string|null $recordComment
 * @property bool|null $recordCommentInheritance
 * @property string|null $recordCurrencyId
 * @property EmailAddresses|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property bool|null $recordFreeTextInheritance
 * @property string|null $recordOpening
 * @property bool|null $recordOpeningInheritance
 * @property string|null $rejectionReason
 * @property string|null $requestDate
 * @property EmailAddresses|null $salesInvoiceEmailAddresses
 * @property EmailAddresses|null $salesOrderEmailAddresses
 * @property float|null $salesProbability
 * @property list<SalesStageHistory>|null $salesStageHistory
 * @property string|null $salesStageId
 * @property bool|null $sentToRecipient
 * @property string|null $servicePeriodFrom
 * @property string|null $servicePeriodTo
 * @property string|null $shipmentMethodId
 * @property list<QuotationShippingCostItem>|null $shippingCostItems
 * @property list<QuotationStatusHistory>|null $statusHistory
 * @property array|null $tags
 * @property bool|null $template
 * @property string|null $validFrom
 * @property string|null $validTo
 * @property string|null $warehouseId
 */
class Quotation extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'commissionSalesPartners' => CommissionSalesPartner::class,
        'customAttributes' => CustomAttribute::class,
        'deliveryAddress' => RecordAddress::class,
        'deliveryEmailAddresses' => EmailAddresses::class,
        'invoiceAddress' => RecordAddress::class,
        'quotationItems' => QuotationItem::class,
        'recordAddress' => RecordAddress::class,
        'recordEmailAddresses' => EmailAddresses::class,
        'salesInvoiceEmailAddresses' => EmailAddresses::class,
        'salesOrderEmailAddresses' => EmailAddresses::class,
        'salesStageHistory' => SalesStageHistory::class,
        'shippingCostItems' => QuotationShippingCostItem::class,
        'statusHistory' => QuotationStatusHistory::class,
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
    public function invoiceRecipient()
    {
        return $this->belongsTo(Party::class, 'invoiceRecipientId');
    }

    /**
     * @return BelongsTo
     */
    public function mergedToQuotation()
    {
        return $this->belongsTo(Quotation::class, 'mergedToQuotationId');
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
    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class, 'opportunityId');
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
    public function salesStage()
    {
        return $this->belongsTo(SalesStage::class, 'salesStageId');
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

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currencyId');
    }

    /**
     * POST /accept
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function accept(array $params = []): ?array
    {
        return $this->newQuery()->callAction('accept', $params, 'POST');
    }

    /**
     * POST /addDefaultScalePricesToItems
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function addDefaultScalePricesToItems(array $params = []): ?array
    {
        return $this->newQuery()->callAction('addDefaultScalePricesToItems', $params, 'POST');
    }

    /**
     * POST /calculateSalesPrices
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function calculateSalesPrices(array $params = []): ?array
    {
        return $this->newQuery()->callAction('calculateSalesPrices', $params, 'POST');
    }

    /**
     * POST /createNewVersion
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createNewVersion(array $params = []): ?array
    {
        return $this->newQuery()->callAction('createNewVersion', $params, 'POST');
    }

    /**
     * POST /createPublicPageLink
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPublicPageLink(array $params = []): ?array
    {
        return $this->newQuery()->callAction('createPublicPageLink', $params, 'POST');
    }

    /**
     * POST /createPurchaseOrderRequest
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPurchaseOrderRequest(array $params = []): ?array
    {
        return $this->newQuery()->callAction('createPurchaseOrderRequest', $params, 'POST');
    }

    /**
     * POST /createQuotationPdf
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createQuotationPdf(array $params = []): ?array
    {
        return $this->newQuery()->callAction('createQuotationPdf', $params, 'POST');
    }

    /**
     * POST /disablePublicPageLink
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function disablePublicPageLink(array $params = []): ?array
    {
        return $this->newQuery()->callAction('disablePublicPageLink', $params, 'POST');
    }

    /**
     * GET /downloadLatestQuotationPdf
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadLatestQuotationPdf(array $params = []): ?array
    {
        return $this->newQuery()->callAction('downloadLatestQuotationPdf', $params, 'GET');
    }

    /**
     * POST /inquire
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function inquire(array $params = []): ?array
    {
        return $this->newQuery()->callAction('inquire', $params, 'POST');
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

    /**
     * GET /printQuotationData
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function printQuotationData(array $params = []): ?array
    {
        return $this->newQuery()->callAction('printQuotationData', $params, 'GET');
    }

    /**
     * POST /recalculateCosts
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function recalculateCosts(array $params = []): ?array
    {
        return $this->newQuery()->callAction('recalculateCosts', $params, 'POST');
    }

    /**
     * POST /resetTaxes
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function resetTaxes(array $params = []): ?array
    {
        return $this->newQuery()->callAction('resetTaxes', $params, 'POST');
    }

    /**
     * POST /setCostsForItemsWithoutCost
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function setCostsForItemsWithoutCost(array $params = []): ?array
    {
        return $this->newQuery()->callAction('setCostsForItemsWithoutCost', $params, 'POST');
    }

    /**
     * POST /updatePrices
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function updatePrices(array $params = []): ?array
    {
        return $this->newQuery()->callAction('updatePrices', $params, 'POST');
    }
}
