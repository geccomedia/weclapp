<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * @return BelongsTo
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventoryId');
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
}
