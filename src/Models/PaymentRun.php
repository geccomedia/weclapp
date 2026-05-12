<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Carbon|null $paymentRunDate
 * @property array|null $paymentRunItems
 * @property string|null $paymentRunNumber
 * @property string|null $runByUserId
 * @property float|null $totalAmount
 */
class PaymentRun extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'createdDate' => 'datetime',
        'lastModifiedDate' => 'datetime',
        'paymentRunDate' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function runByUser()
    {
        return $this->belongsTo(User::class, 'runByUserId');
    }
}
