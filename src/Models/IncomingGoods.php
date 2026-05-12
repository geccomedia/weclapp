<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $incomingGoodsNumber
 * @property string|null $status
 * @property string|null $warehouseId
 * @property string|null $warehouseName
 * @property string|null $supplierId
 * @property string|null $supplierName
 * @property string|null $purchaseOrderId
 * @property string|null $purchaseOrderNumber
 * @property string|null $responsibleUserId
 * @property string|null $note
 * @property Carbon|null $incomingGoodsDate
 * @property array|null $incomingGoodsItems
 * @property string|null $commercialLanguage
 * @property string|null $creatorId
 * @property array|null $customAttributes
 * @property array|null $customerDeliveryAddress
 * @property array|null $customerInvoiceAddress
 * @property string|null $deliveryNoteNumber
 * @property string|null $description
 * @property string|null $dhlReceiverId
 * @property bool|null $disableRecordEmailingRule
 * @property string|null $dropshippingShipmentId
 * @property string|null $incomingGoodsType
 * @property array|null $invoiceAddress
 * @property string|null $invoiceRecipientId
 * @property array|null $purchaseOrders
 * @property array|null $recipientAddress
 * @property string|null $recordComment
 * @property string|null $recordFreeText
 * @property string|null $recordOpening
 * @property string|null $relatedShipmentId
 * @property array|null $returnAddress
 * @property array|null $salesOrders
 * @property string|null $senderCustomerNumber
 * @property string|null $senderPartyId
 * @property string|null $senderSupplierNumber
 * @property bool|null $sentToRecipient
 * @property string|null $shippingReturnCarrierId
 * @property int|null $shippingReturnLabelsCount
 * @property string|null $sourceWarehouseId
 * @property array|null $statusHistory
 * @property array|null $tags
 */
class IncomingGoods extends Model {}
