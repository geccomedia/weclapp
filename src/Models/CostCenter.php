<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $costCenterGroupId
 * @property string|null $costCenterNumber
 * @property string|null $costCenterType
 * @property string|null $description
 */
class CostCenter extends Model
{
    public function costCenterGroup(): BelongsTo
    {
        return $this->belongsTo(CostCenterGroup::class, 'costCenterGroupId');
    }
}
