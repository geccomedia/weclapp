<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $accountForCostsOfMonetaryTrafficId
 * @property string|null $accountForDunningFeeId
 * @property string|null $additionalEcommerceId
 * @property float|null $amount
 * @property float|null $amountCostsOfMonetaryTraffic
 * @property bool|null $cleared
 * @property string|null $createdById
 * @property string|null $currencyId
 * @property string|null $description
 * @property string|null $ecommerceId
 * @property Carbon|null $effectiveDate
 * @property string|null $externalConnectionId
 * @property string|null $externalRecordNumber
 * @property string|null $origin
 * @property string|null $partyId
 * @property string|null $paymentMethodId
 * @property string|null $paymentToleranceAccountId
 * @property string|null $paymentType
 */
class BankTransaction extends Model
{
    protected bool $creatable = false;

    /**
     * @return BelongsTo
     */
    public function accountForCostsOfMonetaryTraffic()
    {
        return $this->belongsTo(LedgerAccount::class, 'accountForCostsOfMonetaryTrafficId');
    }

    /**
     * @return BelongsTo
     */
    public function accountForDunningFee()
    {
        return $this->belongsTo(LedgerAccount::class, 'accountForDunningFeeId');
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
    public function externalConnection()
    {
        return $this->belongsTo(ExternalConnection::class, 'externalConnectionId');
    }

    /**
     * @return BelongsTo
     */
    public function party()
    {
        return $this->belongsTo(Party::class, 'partyId');
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
    public function paymentToleranceAccount()
    {
        return $this->belongsTo(LedgerAccount::class, 'paymentToleranceAccountId');
    }
}
