<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $name
 * @property string|null $warehouseId
 * @property string|null $warehouseName
 * @property string|null $parentId
 * @property bool|null $active
 */
class WarehouseLevel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'warehouseLevel';
}
