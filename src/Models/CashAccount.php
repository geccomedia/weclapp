<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $accountId
 * @property bool|null $active
 * @property string|null $currencyId
 * @property string|null $description
 * @property float|null $openingBalance
 * @property string|null $treasurerId
 */
class CashAccount extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cashAccount';
}
