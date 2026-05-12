<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $name
 * @property string|null $description
 * @property string|null $trackingUrlTemplate
 * @property bool|null $active
 * @property string|null $fulfillmentProviderType
 * @property string|null $warehouseId
 */
class FulfillmentProvider extends Model
{
    /**
     * @return BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }
}
