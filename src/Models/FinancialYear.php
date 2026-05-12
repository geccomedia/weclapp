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
class FinancialYear extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'periods' => Period::class,
    ];

    /**
     * POST /generatePeriods
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function generatePeriods(array $params = []): ?array
    {
        return $this->callAction('generatePeriods', $params, 'POST');
    }
}
