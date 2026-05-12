<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\AccountingTransactionDetail;
use Geccomedia\Weclapp\Traits\IsReadOnly;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Carbon|null $accountingImportDate
 * @property float|null $conversionRate
 * @property Carbon|null $conversionRateDate
 * @property string|null $currencyId
 * @property bool|null $draft
 * @property string|null $externalRecordNumber
 * @property string|null $internalRecordNumber
 * @property bool|null $reverseTransaction
 * @property string|null $status
 * @property Carbon|null $transactionDate
 * @property list<AccountingTransactionDetail>|null $transactionDetails
 * @property Carbon|null $transactionEstablishDate
 * @property string|null $transactionNumber
 * @property string|null $type
 */
class AccountingTransaction extends Model
{
    use IsReadOnly;

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'transactionDetails' => AccountingTransactionDetail::class,
    ];

    /**
     * @return BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currencyId');
    }

    /**
     * POST /batchBooking
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function batchBooking(array $params = []): ?array
    {
        return $this->callAction('batchBooking', $params, 'POST');
    }
}
