<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleNumber
 * @property string|null $name
 * @property string|null $description
 * @property bool|null $active
 * @property array|null $variantArticleAttributes
 * @property array|null $variants
 * @property string|null $primaryArticleId
 * @property string|null $variantArticleName
 * @property string|null $variantArticleNumber
 */
class VariantArticle extends Model
{
    /**
     * @return BelongsTo
     */
    public function primaryArticle()
    {
        return $this->belongsTo(Article::class, 'primaryArticleId');
    }
}
