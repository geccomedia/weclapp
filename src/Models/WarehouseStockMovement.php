<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $articleId
 * @property string|null $articleNumber
 * @property string|null $articleName
 * @property string|null $fromWarehouseId
 * @property string|null $fromWarehouseName
 * @property string|null $toWarehouseId
 * @property string|null $toWarehouseName
 * @property string|null $movementType
 * @property string|null $movementNote
 * @property float|null $quantity
 * @property Carbon|null $movementDate
 * @property string|null $batchNumberId
 * @property string|null $costCenterId
 * @property array|null $customAttributes
 * @property string|null $incomingGoodsItemId
 * @property string|null $internalTransportReferenceId
 * @property string|null $movementNumber
 * @property string|null $postingDate
 * @property string|null $productionOrderId
 * @property string|null $salesOrderItemId
 * @property array|null $serialNumbers
 * @property string|null $shipmentItemId
 * @property string|null $stockMovementType
 * @property string|null $storagePlaceId
 * @property string|null $transportationOrderId
 * @property string|null $userId
 * @property float|null $valuationPrice
 */
class WarehouseStockMovement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'warehouseStockMovement';
}
