<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $cashAccountId
 * @property array|null $cashCountItems
 * @property bool|null $closed
 * @property float|null $closingBalance
 * @property string|null $closingExplanation
 * @property float|null $openingBalance
 * @property Carbon|null $openingDate
 * @property string|null $sheetNumber
 */
class CashAccountSheet extends Model
{
    /**
     * @return BelongsTo
     */
    public function cashAccount()
    {
        return $this->belongsTo(CashAccount::class, 'cashAccountId');
    }
}
