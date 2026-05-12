<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $accountId
 * @property float|null $amount
 * @property string|null $cashAccountSheetId
 * @property bool|null $cleared
 * @property string|null $createdById
 * @property string|null $currencyId
 * @property string|null $description
 * @property Carbon|null $effectiveDate
 * @property string|null $externalRecordNumber
 * @property string|null $origin
 * @property string|null $paymentMethodId
 * @property string|null $paymentType
 * @property string|null $taxId
 */
class CashAccountTransaction extends Model
{
    /**
     * @return BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(LedgerAccount::class, 'accountId');
    }

    /**
     * @return BelongsTo
     */
    public function cashAccountSheet()
    {
        return $this->belongsTo(CashAccountSheet::class, 'cashAccountSheetId');
    }

    /**
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdById');
    }

    /**
     * @return BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currencyId');
    }

    /**
     * @return BelongsTo
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'paymentMethodId');
    }

    /**
     * @return BelongsTo
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'taxId');
    }
}
