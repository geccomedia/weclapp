<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\Traits\NoDelete;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    use NoDelete;

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
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currencyId');
    }

    /**
     * @return BelongsTo
     */
    public function treasurer()
    {
        return $this->belongsTo(User::class, 'treasurerId');
    }
}
