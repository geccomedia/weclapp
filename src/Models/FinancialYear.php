<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $name
 * @property array|null $periods
 * @property string|null $status
 * @property Carbon|null $validFrom
 * @property Carbon|null $validTo
 */
class FinancialYear extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'financialYear';
}
