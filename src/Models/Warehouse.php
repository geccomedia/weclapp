<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $name
 * @property string|null $description
 * @property string|null $warehouseType
 * @property bool|null $active
 * @property array|null $customAttributes
 * @property string|null $defaultConsolidationStoragePlaceId
 * @property string|null $defaultProductionStoragePlaceId
 * @property string|null $defaultReturnsStoragePlaceId
 * @property string|null $defaultStoragePlaceId
 * @property array|null $deliveryAddress
 * @property string|null $directBookingInternalTransportReferenceId
 * @property array|null $invoiceAddress
 * @property string|null $loadingEquipmentStoragePlace
 * @property array|null $primaryAddress
 * @property string|null $shortIdentifier
 * @property bool|null $standard
 * @property string|null $transitStoragePlace
 */
class Warehouse extends Model
{
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
}
