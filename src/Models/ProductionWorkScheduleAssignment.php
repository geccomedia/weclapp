<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

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
}
