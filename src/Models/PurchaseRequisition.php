<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleId
 * @property array|null $customAttributes
 * @property Carbon|null $earliestRequiredDate
 * @property string|null $internalShipmentId
 * @property Carbon|null $latestRequiredDate
 * @property string|null $packagingUnitToOrderId
 * @property string|null $productionOrderId
 * @property string|null $productionOrderItemId
 * @property Carbon|null $proposedDate
 * @property float|null $proposedQuantity
 * @property string|null $purchaseOrderId
 * @property float|null $requirementQuantity
 * @property string|null $requisitionNumber
 * @property string|null $salesOrderItemId
 * @property string|null $status
 * @property array|null $statusHistory
 * @property string|null $supplierId
 * @property string|null $warehouseId
 */
class PurchaseRequisition extends Model
{
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
    public function packagingUnitToOrder()
    {
        return $this->belongsTo(Article::class, 'packagingUnitToOrderId');
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
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchaseOrderId');
    }

    /**
     * @return BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Party::class, 'supplierId');
    }

    /**
     * @return BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }
}
