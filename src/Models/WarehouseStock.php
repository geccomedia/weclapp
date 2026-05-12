<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * @return BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'articleId');
    }

    /**
     * @return BelongsTo
     */
    public function batchNumber()
    {
        return $this->belongsTo(BatchNumber::class, 'batchNumberId');
    }

    /**
     * @return BelongsTo
     */
    public function internalTransportReference()
    {
        return $this->belongsTo(InternalTransportReference::class, 'internalTransportReferenceId');
    }

    /**
     * @return BelongsTo
     */
    public function storagePlace()
    {
        return $this->belongsTo(StoragePlace::class, 'storagePlaceId');
    }

    /**
     * @return BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }
}
