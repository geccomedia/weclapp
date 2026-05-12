<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\Period;

/**
 * @property string|null $name
 * @property list<Period>|null $periods
 * @property string|null $status
 * @property Carbon|null $validFrom
 * @property Carbon|null $validTo
 */
class FinancialYear extends Model {}
