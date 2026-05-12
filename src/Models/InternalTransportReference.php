<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $active
 * @property string|null $internalTransportReferenceNumber
 * @property string|null $loadingEquipmentArticleId
 * @property string|null $loadingEquipmentIdentifierId
 * @property bool|null $permanent
 * @property string|null $warehouseId
 */
class InternalTransportReference extends Model
{
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
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }
}
