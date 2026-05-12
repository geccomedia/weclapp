<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $internalTransportNumber
 * @property string|null $inventoryId
 * @property string|null $loadingEquipmentArticleId
 * @property string|null $loadingEquipmentIdentifierId
 * @property bool|null $manualReference
 */
class InventoryTransportReference extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventoryTransportReference';
}
