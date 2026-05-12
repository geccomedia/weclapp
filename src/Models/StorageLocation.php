<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\NestedStoragePlace;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\SubModels\StoragePlaceTypeSettings;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $active
 * @property bool|null $blockStoragePlaces
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $name
 * @property list<OnlyId>|null $shelves
 * @property string|null $shortIdentifier
 * @property StoragePlaceTypeSettings|null $storagePlaceTypeSettingsBlocked
 * @property StoragePlaceTypeSettings|null $storagePlaceTypeSettingsPicking
 * @property StoragePlaceTypeSettings|null $storagePlaceTypeSettingsStock
 * @property string|null $warehouseId
 */
class StorageLocation extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'blockStoragePlaces' => NestedStoragePlace::class,
        'customAttributes' => CustomAttribute::class,
        'shelves' => OnlyId::class,
        'storagePlaceTypeSettingsBlocked' => StoragePlaceTypeSettings::class,
        'storagePlaceTypeSettingsPicking' => StoragePlaceTypeSettings::class,
        'storagePlaceTypeSettingsStock' => StoragePlaceTypeSettings::class,
    ];

    /**
     * @return BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }
}
