<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ledgerAccount';
}
