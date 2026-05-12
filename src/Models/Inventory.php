<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
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
 * @property array|null $statusHistory
 * @property string|null $warehouseId
 */
class Inventory extends Model
{
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
}
