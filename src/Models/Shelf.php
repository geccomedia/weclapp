<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\NestedStoragePlace;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $active
 * @property string|null $shortIdentifier
 * @property string|null $storageLocationId
 * @property list<NestedStoragePlace>|null $storagePlaces
 */
class Shelf extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'storagePlaces' => NestedStoragePlace::class,
    ];

    /**
     * @return BelongsTo
     */
    public function storageLocation()
    {
        return $this->belongsTo(StorageLocation::class, 'storageLocationId');
    }
}
