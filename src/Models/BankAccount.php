<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $accountHolder
 * @property string|null $accountId
 * @property string|null $accountNumber
 * @property bool|null $active
 * @property bool|null $autoSync
 * @property bool|null $automaticProcessing
 * @property float|null $balance
 * @property string|null $bankCode
 * @property bool|null $connectionFailure
 * @property string|null $creditInstitute
 * @property string|null $creditInstituteCity
 * @property string|null $creditInstituteStreet
 * @property string|null $creditInstituteZip
 * @property float|null $creditLine
 * @property string|null $currencyId
 * @property string|null $differentSepaCreditorIdentifier
 * @property bool|null $enabledForElectronicPaymentTransactions
 * @property string|null $iban
 * @property string|null $incidentalCostsOfMonetaryTrafficAccountId
 * @property string|null $incidentalCostsOfMonetaryTrafficTaxId
 * @property Carbon|null $lastDownload
 * @property bool|null $primary
 * @property string|null $qrIban
 * @property string|null $qrIdentifier
 * @property string|null $swiftBic
 */
class BankAccount extends Model
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
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currencyId');
    }

    /**
     * @return BelongsTo
     */
    public function incidentalCostsOfMonetaryTrafficAccount()
    {
        return $this->belongsTo(LedgerAccount::class, 'incidentalCostsOfMonetaryTrafficAccountId');
    }

    /**
     * @return BelongsTo
     */
    public function incidentalCostsOfMonetaryTrafficTax()
    {
        return $this->belongsTo(Tax::class, 'incidentalCostsOfMonetaryTrafficTaxId');
    }
}
