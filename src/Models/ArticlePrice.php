<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\ReductionAddition;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleId
 * @property string|null $currencyId
 * @property string|null $currencyName
 * @property string|null $priceType
 * @property float|null $price
 * @property float|null $startQuantity
 * @property float|null $endQuantity
 * @property bool|null $reductionAdditionsActive
 * @property string|null $customerId
 * @property string|null $description
 * @property string|null $endDate
 * @property string|null $lastModifiedByUserId
 * @property string|null $priceScaleType
 * @property float|null $priceScaleValue
 * @property list<ReductionAddition>|null $reductionAdditions
 * @property string|null $salesChannel
 * @property string|null $startDate
 */
class ArticlePrice extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'reductionAdditions' => ReductionAddition::class,
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
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currencyId');
    }

    /**
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Party::class, 'customerId');
    }

    /**
     * @return BelongsTo
     */
    public function lastModifiedByUser()
    {
        return $this->belongsTo(User::class, 'lastModifiedByUserId');
    }
}
