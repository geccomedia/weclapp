<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $productionOrderNumber
 * @property string|null $status
 * @property string|null $articleId
 * @property string|null $articleNumber
 * @property string|null $articleName
 * @property string|null $warehouseId
 * @property string|null $warehouseName
 * @property string|null $responsibleUserId
 * @property string|null $note
 * @property float|null $plannedQuantity
 * @property float|null $producedQuantity
 * @property Carbon|null $plannedStartDate
 * @property Carbon|null $plannedEndDate
 * @property array|null $productionOrderItems
 * @property string|null $actualEndDate
 * @property float|null $actualQuantity
 * @property string|null $actualStartDate
 * @property string|null $assemblyStoragePlaceId
 * @property array|null $customAttributes
 * @property string|null $pickingInstructions
 * @property bool|null $picksComplete
 * @property string|null $purchaseOrderItemId
 * @property string|null $salesOrderItemId
 * @property array|null $statusHistory
 * @property string|null $targetEndDate
 * @property float|null $targetQuantity
 * @property string|null $targetStartDate
 * @property array|null $workItems
 */
class ProductionOrder extends Model
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
    public function assemblyStoragePlace()
    {
        return $this->belongsTo(StoragePlace::class, 'assemblyStoragePlaceId');
    }

    /**
     * @return BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }
}
