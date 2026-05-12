<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $articleId
 * @property string|null $articleNumber
 * @property string|null $articleName
 * @property string|null $warehouseId
 * @property string|null $warehouseName
 * @property string|null $warehouseLevelId
 * @property string|null $warehouseLevelName
 * @property float|null $quantity
 * @property float|null $reservedQuantity
 * @property float|null $availableQuantity
 * @property string|null $batchNumberId
 * @property string|null $inboundDate
 * @property string|null $internalTransportReferenceId
 * @property array|null $packagingUnits
 * @property array|null $picks
 * @property string|null $salesOrderItemId
 * @property array|null $serialNumbers
 * @property string|null $storagePlaceId
 */
class WarehouseStock extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'warehouseStock';
}
