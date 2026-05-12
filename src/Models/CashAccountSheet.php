<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

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
class CashAccountSheet extends Model {}
