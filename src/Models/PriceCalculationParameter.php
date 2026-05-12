<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleCategoryId
 * @property string|null $articleId
 * @property float|null $fixSurcharge
 * @property float|null $fromScale
 * @property float|null $lowerPurchasePriceBound
 * @property float|null $margin
 * @property float|null $percentSurcharge
 * @property float|null $profit
 * @property string|null $salesChannel
 */
class PriceCalculationParameter extends Model
{
    /**
     * @return BelongsTo
     */
    public function articleCategory()
    {
        return $this->belongsTo(ArticleCategory::class, 'articleCategoryId');
    }

    /**
     * @return BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'articleId');
    }
}
