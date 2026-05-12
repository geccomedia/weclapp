<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

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
 * @property array|null $customAttributes
 * @property array|null $deliveryAddress
 * @property string|null $description
 * @property float|null $discountPercentage
 * @property Carbon|null $endDate
 * @property bool|null $formSettingsFromSalesChannel
 * @property float|null $headerDiscount
 * @property float|null $headerSurcharge
 * @property array|null $invoiceAddress
 * @property string|null $nonStandardTaxId
 * @property string|null $note
 * @property Carbon|null $orderDate
 * @property float|null $orderQuantity
 * @property string|null $paymentMethodId
 * @property string|null $recipientCountryCode
 * @property array|null $recordAddress
 * @property string|null $recordComment
 * @property string|null $recordCurrencyId
 * @property array|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property string|null $recordOpening
 * @property array|null $reductionAdditionItems
 * @property array|null $releases
 * @property float|null $residualQuantity
 * @property string|null $responsibleUserId
 * @property string|null $senderCountryCode
 * @property bool|null $sentToRecipient
 * @property string|null $shipmentMethodId
 * @property Carbon|null $startDate
 * @property string|null $status
 * @property array|null $statusHistory
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
class BlanketPurchaseOrder extends Model {}
