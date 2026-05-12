<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $batchNumber
 * @property string|null $articleId
 * @property string|null $articleNumber
 * @property string|null $articleName
 * @property string|null $warehouseId
 * @property string|null $warehouseName
 * @property string|null $status
 * @property Carbon|null $expirationDate
 * @property Carbon|null $productionDate
 * @property array|null $customAttributes
 */
class BatchNumber extends Model {}
