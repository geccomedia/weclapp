<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $active
 * @property string|null $shortIdentifier
 * @property string|null $storageLocationId
 * @property array|null $storagePlaces
 */
class Shelf extends Model
{
    /**
     * @return BelongsTo
     */
    public function storageLocation()
    {
        return $this->belongsTo(StorageLocation::class, 'storageLocationId');
    }
}
