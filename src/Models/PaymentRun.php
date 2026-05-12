<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Carbon|null $paymentRunDate
 * @property list<PaymentRunItem>|null $paymentRunItems
 * @property string|null $paymentRunNumber
 * @property string|null $runByUserId
 * @property float|null $totalAmount
 */
class PaymentRun extends Model
{
    protected bool $creatable = false;

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'createdDate' => 'datetime',
        'lastModifiedDate' => 'datetime',
        'paymentRunDate' => 'datetime',
        'paymentRunItems' => PaymentRunItem::class,
    ];

    /**
     * @return BelongsTo
     */
    public function runByUser()
    {
        return $this->belongsTo(User::class, 'runByUserId');
    }
}
