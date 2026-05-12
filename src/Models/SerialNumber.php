<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $serialNumber
 * @property string|null $articleId
 * @property string|null $articleNumber
 * @property string|null $articleName
 * @property string|null $warehouseId
 * @property string|null $warehouseName
 * @property string|null $status
 * @property Carbon|null $warrantyExpirationDate
 * @property array|null $customAttributes
 */
class SerialNumber extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'serialNumber';
}
