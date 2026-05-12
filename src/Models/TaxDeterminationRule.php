<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $accountingCodeId
 * @property string|null $customerDebtorAccountingCodeId
 * @property string|null $dispatchCountryCode
 * @property Carbon|null $endDate
 * @property string|null $partyType
 * @property string|null $recipientCountryCode
 * @property bool|null $sales
 * @property Carbon|null $startDate
 * @property string|null $taxId
 * @property string|null $taxRateType
 * @property bool|null $validVatId
 */
class TaxDeterminationRule extends Model
{
    /**
     * @return BelongsTo
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'taxId');
    }
}
