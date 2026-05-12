<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $active
 * @property bool|null $blockStoragePlaces
 * @property array|null $customAttributes
 * @property string|null $name
 * @property array|null $shelves
 * @property string|null $shortIdentifier
 * @property array|null $storagePlaceTypeSettingsBlocked
 * @property array|null $storagePlaceTypeSettingsPicking
 * @property array|null $storagePlaceTypeSettingsStock
 * @property string|null $warehouseId
 */
class StorageLocation extends Model
{
    /**
     * @return BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }
}
