<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleId
 * @property string|null $batchNumber
 * @property string|null $comment
 * @property float|null $countedQuantity
 * @property Carbon|null $expirationDate
 * @property float|null $expectedQuantity
 * @property Carbon|null $inboundDate
 * @property string|null $inventoryId
 * @property array|null $inventorySerialNumbers
 * @property string|null $inventoryTransportReferenceId
 * @property bool|null $manualPosition
 * @property string|null $orderItemId
 * @property int|null $positionNumber
 * @property float|null $replacementValue
 * @property string|null $storagePlaceId
 */
class InventoryItem extends Model
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
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventoryId');
    }

    /**
     * @return BelongsTo
     */
    public function inventoryTransportReference()
    {
        return $this->belongsTo(InventoryTransportReference::class, 'inventoryTransportReferenceId');
    }

    /**
     * @return BelongsTo
     */
    public function storagePlace()
    {
        return $this->belongsTo(StoragePlace::class, 'storagePlaceId');
    }
}
