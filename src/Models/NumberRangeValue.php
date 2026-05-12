<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\Traits\IsReadOnly;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property list<OnlyId>|null $articleCategories
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
    use IsReadOnly;

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'articleCategories' => OnlyId::class,
    ];

    /**
     * @return BelongsTo
     */
    public function numberRange()
    {
        return $this->belongsTo(NumberRange::class, 'numberRangeId');
    }
}
