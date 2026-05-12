<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

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
 * @property array|null $purchaseOrderItems
 * @property string|null $advancePaymentStatus
 * @property string|null $commercialLanguage
 * @property string|null $commercialLanguageCustomer
 * @property float|null $commission
 * @property string|null $confirmationNumber
 * @property string|null $creatorId
 * @property string|null $currencyConversionDate
 * @property bool|null $currencyConversionLocked
 * @property float|null $currencyConversionRate
 * @property array|null $customAttributes
 * @property array|null $deliveryAddress
 * @property string|null $description
 * @property bool|null $disableRecordEmailingRule
 * @property array|null $dropshippingDeliveryNoteFormTexts
 * @property string|null $externalPurchaseOrderNumber
 * @property bool|null $formSettingsFromSalesChannel
 * @property float|null $grossAmountInCompanyCurrency
 * @property float|null $headerDiscount
 * @property float|null $headerSurcharge
 * @property bool|null $includeCashDiscountInValuationPrice
 * @property array|null $invoiceAddress
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
 * @property array|null $recordAddress
 * @property string|null $recordComment
 * @property string|null $recordCurrencyId
 * @property array|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property string|null $recordOpening
 * @property string|null $salesOrderId
 * @property string|null $senderCountryCode
 * @property bool|null $sentToRecipient
 * @property string|null $servicePeriodFrom
 * @property string|null $servicePeriodTo
 * @property string|null $shipmentMethodId
 * @property string|null $shippingCarrierId
 * @property array|null $shippingCostItems
 * @property string|null $shippingNotificationDate
 * @property array|null $statusHistory
 * @property string|null $supplierHabitualExporterLetterOfIntentId
 * @property string|null $supplierQuotationNumber
 * @property array|null $tags
 */
class PurchaseOrder extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchaseOrder';
}
