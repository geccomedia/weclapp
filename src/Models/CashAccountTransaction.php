<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cashAccountTransaction';
}
