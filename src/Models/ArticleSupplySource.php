<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

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
 * @property array|null $articlePrices
 * @property array|null $customAttributes
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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articleSupplySource';
}
