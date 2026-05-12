<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $batchNumber
 * @property string|null $articleId
 * @property string|null $articleNumber
 * @property string|null $articleName
 * @property string|null $warehouseId
 * @property string|null $warehouseName
 * @property string|null $status
 * @property Carbon|null $expirationDate
 * @property Carbon|null $productionDate
 * @property list<CustomAttribute>|null $customAttributes
 */
class BatchNumber extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customAttributes' => CustomAttribute::class,
    ];

    /**
     * @return BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'articleId');
    }
}
