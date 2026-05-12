<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property array|null $articleCategories
 * @property array|null $creditNoteInvoiceTypes
 * @property string|null $interval
 * @property string|null $lastValue
 * @property int|null $length
 * @property string|null $numberRangeId
 * @property string|null $prefix
 * @property array|null $salesChannels
 * @property array|null $salesInvoiceTypes
 * @property string|null $suffix
 * @property Carbon|null $validFromDate
 * @property Carbon|null $validToDate
 */
class NumberRangeValue extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'numberRangeValue';
}
