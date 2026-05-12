<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleId
 * @property string|null $articleNumber
 * @property bool|null $active
 * @property array|null $attributeValues
 * @property array|null $attributeOptions
 * @property int|null $positionNumber
 * @property string|null $variantArticleId
 */
class VariantArticleVariant extends Model
{
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
    public function variantArticle()
    {
        return $this->belongsTo(VariantArticle::class, 'variantArticleId');
    }
}
