<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\InventorySerialNumber;
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
 * @property list<InventorySerialNumber>|null $inventorySerialNumbers
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
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'inventorySerialNumbers' => InventorySerialNumber::class,
    ];

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
