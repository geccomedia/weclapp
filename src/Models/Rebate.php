<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property list<OnlyId>|null $articleCategories
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
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'articleCategories' => OnlyId::class,
    ];

    /**
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Party::class, 'customerId');
    }
}
