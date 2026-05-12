<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'paymentRun';

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
}
