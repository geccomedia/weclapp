<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $name
 * @property string|null $parentId
 * @property string|null $parentName
 * @property bool|null $active
 * @property string|null $articleAccountingCodeId
 * @property string|null $articleCategoryClassificationId
 * @property string|null $costTypeId
 * @property string|null $description
 * @property string|null $imageId
 * @property string|null $parentCategoryId
 * @property string|null $purchaseCostCenterId
 * @property string|null $salesCostCenterId
 */
class ArticleCategory extends Model
{
    /**
     * @return BelongsTo
     */
    public function costType()
    {
        return $this->belongsTo(CostType::class, 'costTypeId');
    }

    /**
     * @return BelongsTo
     */
    public function parentCategory()
    {
        return $this->belongsTo(ArticleCategory::class, 'parentCategoryId');
    }

    /**
     * @return BelongsTo
     */
    public function purchaseCostCenter()
    {
        return $this->belongsTo(CostCenter::class, 'purchaseCostCenterId');
    }

    /**
     * @return BelongsTo
     */
    public function salesCostCenter()
    {
        return $this->belongsTo(CostCenter::class, 'salesCostCenterId');
    }

    public function articleAccountingCode(): BelongsTo
    {
        return $this->belongsTo(ArticleAccountingCode::class, 'articleAccountingCodeId');
    }

    public function articleCategoryClassification(): BelongsTo
    {
        return $this->belongsTo(ArticleCategoryClassification::class, 'articleCategoryClassificationId');
    }

    /**
     * GET /downloadImage
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadImage(array $params = []): ?array
    {
        return $this->callAction('downloadImage', $params, 'GET');
    }

    /**
     * POST /uploadImage
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function uploadImage(array $params = []): ?array
    {
        return $this->callAction('uploadImage', $params, 'POST');
    }
}
