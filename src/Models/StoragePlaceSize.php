<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $description
 * @property string|null $loadingEquipmentIdentifierId
 * @property string|null $name
 * @property int|null $segmentQuantity
 */
class StoragePlaceSize extends Model
{
    /**
     * @return BelongsTo
     */
    public function loadingEquipmentIdentifier()
    {
        return $this->belongsTo(LoadingEquipmentIdentifier::class, 'loadingEquipmentIdentifierId');
    }
}
