<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string|null $isoCode
 * @property string|null $name
 * @property bool|null $active
 * @property string|null $currencySymbol
 */
class Currency extends Model
{
    public function articlePrices(): HasMany
    {
        return $this->hasMany(ArticlePrice::class, 'currencyId');
    }

    public function articleSupplySources(): HasMany
    {
        return $this->hasMany(ArticleSupplySource::class, 'currencyId');
    }
}
