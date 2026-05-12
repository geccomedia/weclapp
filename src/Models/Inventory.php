<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\InventoryStatusHistory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $counter
 * @property string|null $description
 * @property Carbon|null $endDate
 * @property string|null $inventoryGroupId
 * @property string|null $inventoryNumber
 * @property string|null $levelOfDetail
 * @property string|null $managerId
 * @property string|null $recorder
 * @property Carbon|null $startDate
 * @property string|null $status
 * @property list<InventoryStatusHistory>|null $statusHistory
 * @property string|null $warehouseId
 */
class Inventory extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'statusHistory' => InventoryStatusHistory::class,
    ];

    /**
     * @return BelongsTo
     */
    public function inventoryGroup()
    {
        return $this->belongsTo(InventoryGroup::class, 'inventoryGroupId');
    }

    /**
     * @return BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'managerId');
    }

    /**
     * @return BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }

    /**
     * POST /bookInventory
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function bookInventory(array $params = []): ?array
    {
        return $this->callAction('bookInventory', $params, 'POST');
    }

    /**
     * POST /create
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function create(array $params = []): ?array
    {
        return $this->callAction('create', $params, 'POST');
    }
}
