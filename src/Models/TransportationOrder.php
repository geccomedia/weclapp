<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $assignedUserId
 * @property array|null $customAttributes
 * @property string|null $destinationStoragePlaceId
 * @property string|null $internalTransportReferenceId
 * @property string|null $loadingEquipmentArticleId
 * @property string|null $loadingEquipmentIdentifierId
 * @property array|null $picks
 * @property string|null $productionOrderId
 * @property string|null $shipmentId
 * @property string|null $status
 * @property array|null $statusHistory
 * @property string|null $transportationOrderNumber
 * @property string|null $transportationOrderType
 */
class TransportationOrder extends Model
{
    /**
     * @return BelongsTo
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assignedUserId');
    }

    /**
     * @return BelongsTo
     */
    public function destinationStoragePlace()
    {
        return $this->belongsTo(StoragePlace::class, 'destinationStoragePlaceId');
    }

    /**
     * @return BelongsTo
     */
    public function internalTransportReference()
    {
        return $this->belongsTo(InternalTransportReference::class, 'internalTransportReferenceId');
    }

    /**
     * @return BelongsTo
     */
    public function loadingEquipmentArticle()
    {
        return $this->belongsTo(Article::class, 'loadingEquipmentArticleId');
    }

    /**
     * @return BelongsTo
     */
    public function loadingEquipmentIdentifier()
    {
        return $this->belongsTo(LoadingEquipmentIdentifier::class, 'loadingEquipmentIdentifierId');
    }

    /**
     * @return BelongsTo
     */
    public function productionOrder()
    {
        return $this->belongsTo(ProductionOrder::class, 'productionOrderId');
    }

    /**
     * @return BelongsTo
     */
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipmentId');
    }
}
