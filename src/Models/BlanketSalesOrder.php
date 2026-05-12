<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\BlanketSalesOrderItem;
use Geccomedia\Weclapp\SubModels\BlanketSalesOrderStatusHistory;
use Geccomedia\Weclapp\SubModels\CommissionSalesPartner;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\EmailAddresses;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Geccomedia\Weclapp\SubModels\ReductionAdditionItem;
use Geccomedia\Weclapp\Traits\IsReadOnly;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleId
 * @property string|null $blanketSalesOrderNumber
 * @property string|null $calculationMode
 * @property string|null $commercialLanguage
 * @property list<CommissionSalesPartner>|null $commissionSalesPartners
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $customerId
 * @property string|null $customerReference
 * @property float|null $defaultHeaderDiscount
 * @property float|null $defaultHeaderSurcharge
 * @property string|null $defaultShippingCarrierId
 * @property RecordAddress|null $deliveryAddress
 * @property EmailAddresses|null $deliveryEmailAddresses
 * @property string|null $description
 * @property float|null $discountPercentage
 * @property string|null $distributionChannel
 * @property Carbon|null $endDate
 * @property bool|null $factoring
 * @property string|null $fulfillmentProviderId
 * @property RecordAddress|null $invoiceAddress
 * @property string|null $invoiceRecipientId
 * @property bool|null $manualUnitPrice
 * @property string|null $nonStandardTaxId
 * @property string|null $note
 * @property Carbon|null $orderDate
 * @property string|null $orderNumberAtCustomer
 * @property float|null $orderQuantity
 * @property string|null $paymentMethodId
 * @property string|null $recipientCountryCode
 * @property RecordAddress|null $recordAddress
 * @property string|null $recordCurrencyId
 * @property EmailAddresses|null $recordEmailAddresses
 * @property list<ReductionAdditionItem>|null $reductionAdditionItems
 * @property list<BlanketSalesOrderItem>|null $releases
 * @property string|null $responsibleUserId
 * @property EmailAddresses|null $salesInvoiceEmailAddresses
 * @property bool|null $sentToRecipient
 * @property string|null $shipmentMethodId
 * @property Carbon|null $startDate
 * @property string|null $status
 * @property list<BlanketSalesOrderStatusHistory>|null $statusHistory
 * @property array|null $tags
 * @property string|null $taxId
 * @property string|null $termOfPaymentId
 * @property float|null $unitPrice
 * @property string|null $warehouseId
 */
class BlanketSalesOrder extends Model
{
    use IsReadOnly;

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'commissionSalesPartners' => CommissionSalesPartner::class,
        'customAttributes' => CustomAttribute::class,
        'deliveryAddress' => RecordAddress::class,
        'deliveryEmailAddresses' => EmailAddresses::class,
        'invoiceAddress' => RecordAddress::class,
        'recordAddress' => RecordAddress::class,
        'recordEmailAddresses' => EmailAddresses::class,
        'reductionAdditionItems' => ReductionAdditionItem::class,
        'releases' => BlanketSalesOrderItem::class,
        'salesInvoiceEmailAddresses' => EmailAddresses::class,
        'statusHistory' => BlanketSalesOrderStatusHistory::class,
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
