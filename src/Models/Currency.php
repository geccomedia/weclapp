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

    /**
     * GET /companyCurrency
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function companyCurrency(array $params = []): ?array
    {
        return $this->callAction('companyCurrency', $params, 'GET');
    }
}
