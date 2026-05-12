<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\Address;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\MinimalStoragePlace;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string|null $name
 * @property string|null $description
 * @property string|null $warehouseType
 * @property bool|null $active
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $defaultConsolidationStoragePlaceId
 * @property string|null $defaultProductionStoragePlaceId
 * @property string|null $defaultReturnsStoragePlaceId
 * @property string|null $defaultStoragePlaceId
 * @property Address|null $deliveryAddress
 * @property string|null $directBookingInternalTransportReferenceId
 * @property Address|null $invoiceAddress
 * @property string|null $loadingEquipmentStoragePlace
 * @property Address|null $primaryAddress
 * @property string|null $shortIdentifier
 * @property bool|null $standard
 * @property string|null $transitStoragePlace
 */
class Warehouse extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customAttributes' => CustomAttribute::class,
        'deliveryAddress' => Address::class,
        'invoiceAddress' => Address::class,
        'loadingEquipmentStoragePlace' => MinimalStoragePlace::class,
        'primaryAddress' => Address::class,
        'transitStoragePlace' => MinimalStoragePlace::class,
    ];

    /**
     * @return BelongsTo
     */
    public function defaultConsolidationStoragePlace()
    {
        return $this->belongsTo(StoragePlace::class, 'defaultConsolidationStoragePlaceId');
    }

    /**
     * @return BelongsTo
     */
    public function defaultProductionStoragePlace()
    {
        return $this->belongsTo(StoragePlace::class, 'defaultProductionStoragePlaceId');
    }

    /**
     * @return BelongsTo
     */
    public function defaultReturnsStoragePlace()
    {
        return $this->belongsTo(StoragePlace::class, 'defaultReturnsStoragePlaceId');
    }

    /**
     * @return BelongsTo
     */
    public function defaultStoragePlace()
    {
        return $this->belongsTo(StoragePlace::class, 'defaultStoragePlaceId');
    }

    /**
     * @return BelongsTo
     */
    public function directBookingInternalTransportReference()
    {
        return $this->belongsTo(InternalTransportReference::class, 'directBookingInternalTransportReferenceId');
    }

    public function warehouseStock(): HasMany
    {
        return $this->hasMany(WarehouseStock::class, 'warehouseId');
    }

    public function storageLocations(): HasMany
    {
        return $this->hasMany(StorageLocation::class, 'warehouseId');
    }

    public function storagePlaces(): HasMany
    {
        return $this->hasMany(StoragePlace::class, 'warehouseId');
    }

    /**
     * POST /activate
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function activate(array $params = []): ?array
    {
        return $this->callAction('activate', $params, 'POST');
    }

    /**
     * POST /deactivate
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function deactivate(array $params = []): ?array
    {
        return $this->callAction('deactivate', $params, 'POST');
    }
}
