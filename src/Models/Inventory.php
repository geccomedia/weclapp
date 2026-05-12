<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

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
class Inventory extends Model {}
