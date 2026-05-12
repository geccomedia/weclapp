<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property array|null $articleCategories
 * @property string|null $customerId
 * @property string|null $description
 * @property Carbon|null $endDate
 * @property string|null $salesChannel
 * @property Carbon|null $startDate
 * @property string|null $type
 * @property float|null $value
 */
class Rebate extends Model
{
    /**
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Party::class, 'customerId');
    }
}
