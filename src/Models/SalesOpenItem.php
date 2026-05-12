<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\PaymentApplication;
use Geccomedia\Weclapp\Traits\IsReadOnly;
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
    use IsReadOnly;

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

    /**
     * POST /createPaymentApplication
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPaymentApplication(array $params = []): ?array
    {
        return $this->callAction('createPaymentApplication', $params, 'POST');
    }

    /**
     * POST /updatePaymentState
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function updatePaymentState(array $params = []): ?array
    {
        return $this->callAction('updatePaymentState', $params, 'POST');
    }
}
