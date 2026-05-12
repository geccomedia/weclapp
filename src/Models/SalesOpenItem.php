<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property float|null $amount
 * @property float|null $amountDiscount
 * @property float|null $amountOpen
 * @property float|null $amountPaid
 * @property Carbon|null $clearanceDate
 * @property bool|null $cleared
 * @property string|null $openItemNumber
 * @property string|null $openItemType
 * @property array|null $paymentApplications
 * @property string|null $salesInvoiceId
 */
class SalesOpenItem extends Model {}
