<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $articleId
 * @property array|null $customAttributes
 * @property Carbon|null $earliestRequiredDate
 * @property string|null $internalShipmentId
 * @property Carbon|null $latestRequiredDate
 * @property string|null $packagingUnitToOrderId
 * @property string|null $productionOrderId
 * @property string|null $productionOrderItemId
 * @property Carbon|null $proposedDate
 * @property float|null $proposedQuantity
 * @property string|null $purchaseOrderId
 * @property float|null $requirementQuantity
 * @property string|null $requisitionNumber
 * @property string|null $salesOrderItemId
 * @property string|null $status
 * @property array|null $statusHistory
 * @property string|null $supplierId
 * @property string|null $warehouseId
 */
class PurchaseRequisition extends Model {}
