<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\PaymentApplication;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property float|null $amount
 * @property float|null $amountDiscount
 * @property float|null $amountOpen
 * @property float|null $amountPaid
 * @property Carbon|null $clearanceDate
 * @property bool|null $cleared
 * @property string|null $openItemNumber
 * @property string|null $openItemType
 * @property list<PaymentApplication>|null $paymentApplications
 * @property string|null $salesInvoiceId
 */
class SalesOpenItem extends Model
{
    protected bool $creatable = false;

    protected bool $deletable = false;

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'paymentApplications' => PaymentApplication::class,
    ];

    /**
     * @return BelongsTo
     */
    public function salesInvoice()
    {
        return $this->belongsTo(SalesInvoice::class, 'salesInvoiceId');
    }
}
