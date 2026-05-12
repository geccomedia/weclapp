<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $accountNumber
 * @property bool|null $automatic
 * @property bool|null $balanceSheetItem
 * @property string|null $description
 * @property string|null $parentAccountId
 * @property string|null $type
 */
class LedgerAccount extends Model
{
    /**
     * @return BelongsTo
     */
    public function parentAccount()
    {
        return $this->belongsTo(LedgerAccount::class, 'parentAccountId');
    }
}
