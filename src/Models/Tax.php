<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string|null $name
 * @property string|null $countryCode
 * @property string|null $taxType
 * @property float|null $taxRate
 * @property bool|null $active
 * @property string|null $accountId
 * @property string|null $contraAccountId
 * @property string|null $defaultDiscountAccountId
 * @property string|null $defaultNominalAccountId
 * @property string|null $depositAccountId
 * @property string|null $taxKey
 * @property float|null $taxValue
 */
class Tax extends Model
{
    /**
     * @return BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(LedgerAccount::class, 'accountId');
    }

    /**
     * @return BelongsTo
     */
    public function contraAccount()
    {
        return $this->belongsTo(LedgerAccount::class, 'contraAccountId');
    }

    /**
     * @return BelongsTo
     */
    public function defaultDiscountAccount()
    {
        return $this->belongsTo(LedgerAccount::class, 'defaultDiscountAccountId');
    }

    /**
     * @return BelongsTo
     */
    public function defaultNominalAccount()
    {
        return $this->belongsTo(LedgerAccount::class, 'defaultNominalAccountId');
    }

    /**
     * @return BelongsTo
     */
    public function depositAccount()
    {
        return $this->belongsTo(LedgerAccount::class, 'depositAccountId');
    }

    public function salesOrders(): HasMany
    {
        return $this->hasMany(SalesOrder::class, 'nonStandardTaxId');
    }

    /**
     * POST /configurePurchaseTaxes
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public static function configurePurchaseTaxes(array $params = []): ?array
    {
        return (new self)->newQuery()->action('configurePurchaseTaxes', $params, 'POST');
    }

    /**
     * POST /configureSalesTaxes
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public static function configureSalesTaxes(array $params = []): ?array
    {
        return (new self)->newQuery()->action('configureSalesTaxes', $params, 'POST');
    }

    /**
     * GET /findPurchaseTax
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public static function findPurchaseTax(array $params = []): ?array
    {
        return (new self)->newQuery()->action('findPurchaseTax', $params, 'GET');
    }

    /**
     * GET /findSalesTax
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public static function findSalesTax(array $params = []): ?array
    {
        return (new self)->newQuery()->action('findSalesTax', $params, 'GET');
    }

    /**
     * POST /resetSystemTaxes
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public static function resetSystemTaxes(array $params = []): ?array
    {
        return (new self)->newQuery()->action('resetSystemTaxes', $params, 'POST');
    }
}
