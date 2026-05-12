<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $active
 * @property string|null $barcode
 * @property bool|null $blockedForResupply
 * @property string|null $blockedForResupplyReasonId
 * @property string|null $currentInventoryId
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $customerId
 * @property int|null $fieldNumber
 * @property int|null $levelNumber
 * @property string|null $name
 * @property string|null $shelfId
 * @property string|null $shelfStorageLocationId
 * @property string|null $storageLocationId
 * @property string|null $storagePlaceSizeId
 * @property string|null $storagePlaceType
 * @property string|null $warehouseId
 */
class StoragePlace extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customAttributes' => CustomAttribute::class,
    ];

    /**
     * @return BelongsTo
     */
    public function currentInventory()
    {
        return $this->belongsTo(Inventory::class, 'currentInventoryId');
    }

    /**
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Party::class, 'customerId');
    }

    /**
     * @return BelongsTo
     */
    public function shelf()
    {
        return $this->belongsTo(Shelf::class, 'shelfId');
    }

    /**
     * @return BelongsTo
     */
    public function shelfStorageLocation()
    {
        return $this->belongsTo(StorageLocation::class, 'shelfStorageLocationId');
    }

    /**
     * @return BelongsTo
     */
    public function storageLocation()
    {
        return $this->belongsTo(StorageLocation::class, 'storageLocationId');
    }

    /**
     * @return BelongsTo
     */
    public function storagePlaceSize()
    {
        return $this->belongsTo(StoragePlaceSize::class, 'storagePlaceSizeId');
    }

    /**
     * @return BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }
}
