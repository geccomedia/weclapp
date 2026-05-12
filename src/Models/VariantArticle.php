<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\VariantArticleVariantWithoutReference;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleNumber
 * @property string|null $name
 * @property string|null $description
 * @property bool|null $active
 * @property array|null $variantArticleAttributes
 * @property list<VariantArticleVariantWithoutReference>|null $variants
 * @property string|null $primaryArticleId
 * @property string|null $variantArticleName
 * @property string|null $variantArticleNumber
 */
class VariantArticle extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'variants' => VariantArticleVariantWithoutReference::class,
    ];

    /**
     * @return BelongsTo
     */
    public function primaryArticle()
    {
        return $this->belongsTo(Article::class, 'primaryArticleId');
    }
}
