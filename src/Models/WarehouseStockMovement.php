<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleId
 * @property string|null $articleNumber
 * @property string|null $articleName
 * @property string|null $fromWarehouseId
 * @property string|null $fromWarehouseName
 * @property string|null $toWarehouseId
 * @property string|null $toWarehouseName
 * @property string|null $movementType
 * @property string|null $movementNote
 * @property float|null $quantity
 * @property Carbon|null $movementDate
 * @property string|null $batchNumberId
 * @property string|null $costCenterId
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $incomingGoodsItemId
 * @property string|null $internalTransportReferenceId
 * @property string|null $movementNumber
 * @property string|null $postingDate
 * @property string|null $productionOrderId
 * @property string|null $salesOrderItemId
 * @property list<OnlyId>|null $serialNumbers
 * @property string|null $shipmentItemId
 * @property string|null $stockMovementType
 * @property string|null $storagePlaceId
 * @property string|null $transportationOrderId
 * @property string|null $userId
 * @property float|null $valuationPrice
 */
class WarehouseStockMovement extends Model
{
    protected bool $creatable = false;

    protected bool $deletable = false;

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customAttributes' => CustomAttribute::class,
        'serialNumbers' => OnlyId::class,
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
    public function batchNumber()
    {
        return $this->belongsTo(BatchNumber::class, 'batchNumberId');
    }

    /**
     * @return BelongsTo
     */
    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'costCenterId');
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
    public function productionOrder()
    {
        return $this->belongsTo(ProductionOrder::class, 'productionOrderId');
    }

    /**
     * @return BelongsTo
     */
    public function storagePlace()
    {
        return $this->belongsTo(StoragePlace::class, 'storagePlaceId');
    }

    /**
     * @return BelongsTo
     */
    public function transportationOrder()
    {
        return $this->belongsTo(TransportationOrder::class, 'transportationOrderId');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
