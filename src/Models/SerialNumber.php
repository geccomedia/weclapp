<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $serialNumber
 * @property string|null $articleId
 * @property string|null $articleNumber
 * @property string|null $articleName
 * @property string|null $warehouseId
 * @property string|null $warehouseName
 * @property string|null $status
 * @property Carbon|null $warrantyExpirationDate
 * @property list<CustomAttribute>|null $customAttributes
 */
class SerialNumber extends Model
{
    protected bool $creatable = false;

    protected bool $deletable = false;

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

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }
}
