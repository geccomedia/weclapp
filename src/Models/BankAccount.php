<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bankAccount';
}
