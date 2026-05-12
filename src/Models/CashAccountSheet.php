<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CashAccountCashCountItem;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $cashAccountId
 * @property list<CashAccountCashCountItem>|null $cashCountItems
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
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'cashCountItems' => CashAccountCashCountItem::class,
    ];

    /**
     * @return BelongsTo
     */
    public function cashAccount()
    {
        return $this->belongsTo(CashAccount::class, 'cashAccountId');
    }
}
