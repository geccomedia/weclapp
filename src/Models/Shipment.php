<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $shipmentNumber
 * @property string|null $status
 * @property string|null $warehouseId
 * @property string|null $warehouseName
 * @property string|null $customerId
 * @property string|null $customerName
 * @property string|null $salesOrderId
 * @property string|null $salesOrderNumber
 * @property string|null $responsibleUserId
 * @property string|null $trackingNumber
 * @property string|null $shipmentMethodId
 * @property string|null $shipmentMethodName
 * @property string|null $fulfillmentProviderId
 * @property string|null $note
 * @property Carbon|null $shipmentDate
 * @property array|null $shipmentItems
 * @property string|null $additionalDeliveryInformation
 * @property string|null $commercialLanguage
 * @property string|null $consolidationStoragePlaceId
 * @property string|null $creatorId
 * @property array|null $customAttributes
 * @property string|null $customerPurchaseOrderNumber
 * @property float|null $declaredValueAmount
 * @property string|null $declaredValueAmountCurrencyId
 * @property string|null $deliveryDate
 * @property string|null $description
 * @property string|null $destinationStoragePlaceId
 * @property string|null $destinationWarehouseId
 * @property string|null $dhlReceiverId
 * @property bool|null $disableRecordEmailingRule
 * @property array|null $invoiceAddress
 * @property string|null $invoiceRecipientId
 * @property string|null $mainSalesOrderId
 * @property float|null $packageHeight
 * @property float|null $packageLength
 * @property string|null $packageReferenceNumber
 * @property string|null $packageReturnTrackingNumber
 * @property string|null $packageReturnTrackingUrl
 * @property string|null $packageTrackingNumber
 * @property string|null $packageTrackingUrl
 * @property float|null $packageWeight
 * @property float|null $packageWidth
 * @property array|null $parcels
 * @property string|null $pickingInstructions
 * @property bool|null $picksComplete
 * @property array|null $purchaseOrders
 * @property array|null $recipientAddress
 * @property string|null $recipientCustomerNumber
 * @property string|null $recipientPartyId
 * @property string|null $recipientSupplierNumber
 * @property string|null $recordComment
 * @property array|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property string|null $recordOpening
 * @property array|null $salesInvoiceEmailAddresses
 * @property array|null $salesOrders
 * @property bool|null $sentToRecipient
 * @property string|null $shipmentType
 * @property array|null $shippedFromAddress
 * @property string|null $shippingCarrierId
 * @property string|null $shippingDate
 * @property int|null $shippingLabelsCount
 * @property string|null $shippingReturnCarrierId
 * @property int|null $shippingReturnLabelsCount
 * @property array|null $statusHistory
 * @property array|null $tags
 * @property float|null $totalWeight
 */
class Shipment extends Model {}
