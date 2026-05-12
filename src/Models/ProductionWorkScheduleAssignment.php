<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $alternative
 * @property string|null $articleId
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $productionWorkScheduleId
 * @property Carbon|null $validFrom
 * @property Carbon|null $validTo
 */
class ProductionWorkScheduleAssignment extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'createdDate' => 'datetime',
        'lastModifiedDate' => 'datetime',
        'validFrom' => 'datetime',
        'validTo' => 'datetime',
        'customAttributes' => CustomAttribute::class,
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
