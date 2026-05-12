<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\ProductionOrderItem;
use Geccomedia\Weclapp\SubModels\ProductionOrderStatusHistory;
use Geccomedia\Weclapp\SubModels\ProductionOrderWorkItem;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $productionOrderNumber
 * @property string|null $status
 * @property string|null $articleId
 * @property string|null $articleNumber
 * @property string|null $articleName
 * @property string|null $warehouseId
 * @property string|null $warehouseName
 * @property string|null $responsibleUserId
 * @property string|null $note
 * @property float|null $plannedQuantity
 * @property float|null $producedQuantity
 * @property Carbon|null $plannedStartDate
 * @property Carbon|null $plannedEndDate
 * @property list<ProductionOrderItem>|null $productionOrderItems
 * @property string|null $actualEndDate
 * @property float|null $actualQuantity
 * @property string|null $actualStartDate
 * @property string|null $assemblyStoragePlaceId
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $pickingInstructions
 * @property bool|null $picksComplete
 * @property string|null $purchaseOrderItemId
 * @property string|null $salesOrderItemId
 * @property list<ProductionOrderStatusHistory>|null $statusHistory
 * @property string|null $targetEndDate
 * @property float|null $targetQuantity
 * @property string|null $targetStartDate
 * @property list<ProductionOrderWorkItem>|null $workItems
 */
class ProductionOrder extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customAttributes' => CustomAttribute::class,
        'productionOrderItems' => ProductionOrderItem::class,
        'statusHistory' => ProductionOrderStatusHistory::class,
        'workItems' => ProductionOrderWorkItem::class,
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
    public function assemblyStoragePlace()
    {
        return $this->belongsTo(StoragePlace::class, 'assemblyStoragePlaceId');
    }

    /**
     * @return BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }

    /**
     * POST /createPickingList
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPickingList(array $params = []): ?array
    {
        return $this->newQuery()->callAction('createPickingList', $params, 'POST');
    }

    /**
     * POST /createPickingOrder
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPickingOrder(array $params = []): ?array
    {
        return $this->newQuery()->callAction('createPickingOrder', $params, 'POST');
    }

    /**
     * GET /downloadLatestProductionOrderPdf
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadLatestProductionOrderPdf(array $params = []): ?array
    {
        return $this->newQuery()->callAction('downloadLatestProductionOrderPdf', $params, 'GET');
    }

    /**
     * POST /fastProductionBooking
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public static function fastProductionBooking(array $params = []): ?array
    {
        return (new self)->newQuery()->action('fastProductionBooking', $params, 'POST');
    }
}
