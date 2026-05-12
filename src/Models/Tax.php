<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tax';
}
