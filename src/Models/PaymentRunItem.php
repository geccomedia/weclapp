<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property float|null $amountDiscount
 * @property float|null $amountPayment
 * @property string|null $bankAccountId
 * @property string|null $bankTransactionId
 * @property bool|null $cleared
 * @property float|null $conversionRate
 * @property Carbon|null $conversionRateDate
 * @property string|null $partyBankAccountId
 * @property string|null $paymentRunId
 * @property string|null $paymentRunPaymentType
 * @property string|null $purchaseOpenItemId
 * @property string|null $purpose
 * @property string|null $recordCurrency
 */
class PaymentRunItem extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'conversionRateDate' => 'datetime',
        'createdDate' => 'datetime',
        'lastModifiedDate' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'bankAccountId');
    }

    /**
     * @return BelongsTo
     */
    public function paymentRun()
    {
        return $this->belongsTo(PaymentRun::class, 'paymentRunId');
    }

    /**
     * @return BelongsTo
     */
    public function purchaseOpenItem()
    {
        return $this->belongsTo(PurchaseOpenItem::class, 'purchaseOpenItemId');
    }
}
