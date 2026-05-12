<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $commercialLanguage
 * @property float|null $commission
 * @property Carbon|null $confirmationDeadline
 * @property string|null $creatorId
 * @property array|null $customAttributes
 * @property array|null $deliveryAddress
 * @property string|null $description
 * @property bool|null $disableRecordEmailingRule
 * @property array|null $invoiceAddress
 * @property Carbon|null $plannedDeliveryDate
 * @property array|null $purchaseOrderRequestItems
 * @property string|null $purchaseOrderRequestNumber
 * @property array|null $purchaseOrderRequestOffers
 * @property string|null $purchaseOrderRequestType
 * @property string|null $quotationId
 * @property array|null $recordAddress
 * @property string|null $recordComment
 * @property string|null $recordFreeText
 * @property string|null $recordOpening
 * @property string|null $responsibleUserId
 * @property string|null $salesOrderId
 * @property bool|null $sentToRecipient
 * @property string|null $status
 * @property array|null $statusHistory
 * @property array|null $tags
 * @property string|null $warehouseId
 */
class PurchaseOrderRequest extends Model {}
