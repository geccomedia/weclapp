<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $alternative
 * @property string|null $articleId
 * @property array|null $customAttributes
 * @property string|null $productionWorkScheduleId
 * @property Carbon|null $validFrom
 * @property Carbon|null $validTo
 */
class ProductionWorkScheduleAssignment extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'createdDate' => 'datetime',
        'lastModifiedDate' => 'datetime',
        'validFrom' => 'datetime',
        'validTo' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'articleId');
    }

    /**
     * @return BelongsTo
     */
    public function productionWorkSchedule()
    {
        return $this->belongsTo(ProductionWorkSchedule::class, 'productionWorkScheduleId');
    }
}
