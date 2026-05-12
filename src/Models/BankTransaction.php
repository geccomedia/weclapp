<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

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
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bankTransaction';
}
