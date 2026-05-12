<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $articleId
 * @property string|null $blanketSalesOrderNumber
 * @property string|null $calculationMode
 * @property string|null $commercialLanguage
 * @property array|null $commissionSalesPartners
 * @property array|null $customAttributes
 * @property string|null $customerId
 * @property string|null $customerReference
 * @property float|null $defaultHeaderDiscount
 * @property float|null $defaultHeaderSurcharge
 * @property string|null $defaultShippingCarrierId
 * @property array|null $deliveryAddress
 * @property array|null $deliveryEmailAddresses
 * @property string|null $description
 * @property float|null $discountPercentage
 * @property string|null $distributionChannel
 * @property Carbon|null $endDate
 * @property bool|null $factoring
 * @property string|null $fulfillmentProviderId
 * @property array|null $invoiceAddress
 * @property string|null $invoiceRecipientId
 * @property bool|null $manualUnitPrice
 * @property string|null $nonStandardTaxId
 * @property string|null $note
 * @property Carbon|null $orderDate
 * @property string|null $orderNumberAtCustomer
 * @property float|null $orderQuantity
 * @property string|null $paymentMethodId
 * @property string|null $recipientCountryCode
 * @property array|null $recordAddress
 * @property string|null $recordCurrencyId
 * @property array|null $recordEmailAddresses
 * @property array|null $reductionAdditionItems
 * @property array|null $releases
 * @property string|null $responsibleUserId
 * @property array|null $salesInvoiceEmailAddresses
 * @property bool|null $sentToRecipient
 * @property string|null $shipmentMethodId
 * @property Carbon|null $startDate
 * @property string|null $status
 * @property array|null $statusHistory
 * @property array|null $tags
 * @property string|null $taxId
 * @property string|null $termOfPaymentId
 * @property float|null $unitPrice
 * @property string|null $warehouseId
 */
class BlanketSalesOrder extends Model {}
