<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\BlanketPurchaseOrderStatusHistory;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\EmailAddresses;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Geccomedia\Weclapp\SubModels\ReductionAdditionItem;
use Geccomedia\Weclapp\SubModels\Releases;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleId
 * @property string|null $blanketPurchaseOrderNumber
 * @property string|null $calculationMode
 * @property string|null $commercialLanguage
 * @property string|null $confirmationNumber
 * @property string|null $creatorId
 * @property Carbon|null $currencyConversionDate
 * @property bool|null $currencyConversionLocked
 * @property float|null $currencyConversionRate
 * @property list<CustomAttribute>|null $customAttributes
 * @property RecordAddress|null $deliveryAddress
 * @property string|null $description
 * @property float|null $discountPercentage
 * @property Carbon|null $endDate
 * @property bool|null $formSettingsFromSalesChannel
 * @property float|null $headerDiscount
 * @property float|null $headerSurcharge
 * @property RecordAddress|null $invoiceAddress
 * @property string|null $nonStandardTaxId
 * @property string|null $note
 * @property Carbon|null $orderDate
 * @property float|null $orderQuantity
 * @property string|null $paymentMethodId
 * @property string|null $recipientCountryCode
 * @property RecordAddress|null $recordAddress
 * @property string|null $recordComment
 * @property string|null $recordCurrencyId
 * @property EmailAddresses|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property string|null $recordOpening
 * @property list<ReductionAdditionItem>|null $reductionAdditionItems
 * @property list<Releases>|null $releases
 * @property float|null $residualQuantity
 * @property string|null $responsibleUserId
 * @property string|null $senderCountryCode
 * @property bool|null $sentToRecipient
 * @property string|null $shipmentMethodId
 * @property Carbon|null $startDate
 * @property string|null $status
 * @property list<BlanketPurchaseOrderStatusHistory>|null $statusHistory
 * @property string|null $supplierBlanketPurchaseOrderNumber
 * @property string|null $supplierId
 * @property string|null $supplierQuotationNumber
 * @property array|null $tags
 * @property string|null $taxId
 * @property string|null $termOfPaymentId
 * @property float|null $unitPrice
 * @property bool|null $useManualUnitPrice
 * @property string|null $warehouseId
 */
class BlanketPurchaseOrder extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customAttributes' => CustomAttribute::class,
        'deliveryAddress' => RecordAddress::class,
        'invoiceAddress' => RecordAddress::class,
        'recordAddress' => RecordAddress::class,
        'recordEmailAddresses' => EmailAddresses::class,
        'reductionAdditionItems' => ReductionAdditionItem::class,
        'releases' => Releases::class,
        'statusHistory' => BlanketPurchaseOrderStatusHistory::class,
    ];

    /**
     * @return BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'articleId');
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
    public function shipmentMethod()
    {
        return $this->belongsTo(ShipmentMethod::class, 'shipmentMethodId');
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
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'taxId');
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
