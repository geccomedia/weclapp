<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'priceCalculationParameter';
}
