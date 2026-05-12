<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $name
 * @property string|null $description
 * @property int|null $netDueDays
 * @property int|null $discountDays1
 * @property float|null $discountPercentage1
 * @property int|null $discountDays2
 * @property float|null $discountPercentage2
 * @property bool|null $active
 * @property array|null $conditions
 * @property int|null $datevTermOfPaymentNumber
 * @property string|null $dueDateOption
 * @property int|null $fixedDay
 * @property int|null $numberOfDays
 * @property string|null $reference
 * @property string|null $validFrom
 * @property string|null $validTo
 */
class TermOfPayment extends Model {}
