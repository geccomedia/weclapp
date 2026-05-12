<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

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
 * @property array|null $transactionDetails
 * @property Carbon|null $transactionEstablishDate
 * @property string|null $transactionNumber
 * @property string|null $type
 */
class AccountingTransaction extends Model {}
