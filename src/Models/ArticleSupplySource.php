<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\ArticlePriceWithoutSalesChannel;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleId
 * @property string|null $supplierId
 * @property string|null $supplierName
 * @property string|null $supplierArticleNumber
 * @property string|null $currencyId
 * @property float|null $purchasePrice
 * @property float|null $deliveryTime
 * @property bool|null $primary
 * @property string|null $articleNumber
 * @property list<ArticlePriceWithoutSalesChannel>|null $articlePrices
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $description
 * @property bool|null $dropshippingPossible
 * @property string|null $ean
 * @property float|null $fixedPurchaseQuantity
 * @property bool|null $ignoreInDropshippingAutomation
 * @property string|null $internalNote
 * @property string|null $manufacturerPartNumber
 * @property string|null $matchCode
 * @property float|null $minimumPurchaseQuantity
 * @property string|null $name
 * @property int|null $procurementLeadDays
 * @property string|null $shortDescription1
 * @property string|null $shortDescription2
 * @property float|null $supplierStockQuantity
 * @property string|null $taxRateType
 * @property string|null $unitId
 */
class ArticleSupplySource extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'articlePrices' => ArticlePriceWithoutSalesChannel::class,
        'customAttributes' => CustomAttribute::class,
    ];

    /**
     * @return BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Party::class, 'supplierId');
    }

    /**
     * @return BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unitId');
    }
}
