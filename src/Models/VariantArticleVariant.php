<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleId
 * @property string|null $articleNumber
 * @property bool|null $active
 * @property array|null $attributeValues
 * @property list<OnlyId>|null $attributeOptions
 * @property int|null $positionNumber
 * @property string|null $variantArticleId
 */
class VariantArticleVariant extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'attributeOptions' => OnlyId::class,
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
    public function variantArticle()
    {
        return $this->belongsTo(VariantArticle::class, 'variantArticleId');
    }
}
