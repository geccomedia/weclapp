<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property bool|null $customerReturn
 * @property string|null $name
 * @property int|null $position
 * @property bool|null $supplierReturn
 */
class ShipmentReturnAssessment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shipmentReturnAssessment';
}
