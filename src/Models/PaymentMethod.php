<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $name
 * @property string|null $description
 * @property string|null $paymentMethodType
 * @property bool|null $active
 * @property bool|null $autoClearingAccountTransaction
 * @property string|null $clearingAccountId
 * @property float|null $discountPercentage
 * @property float|null $discountValue
 * @property string|null $documentText
 * @property string|null $reference
 * @property string|null $type
 */
class PaymentMethod extends Model {}
