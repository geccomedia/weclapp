<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $bankAccountId
 * @property Carbon|null $cancellationDate
 * @property string|null $description
 * @property bool|null $firstDebit
 * @property string|null $mandateReference
 * @property string|null $partyBankAccountId
 * @property string|null $runtime
 * @property Carbon|null $signatureDate
 * @property string|null $type
 */
class SepaDirectDebitMandate extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sepaDirectDebitMandate';
}
