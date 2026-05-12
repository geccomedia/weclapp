<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $description
 * @property string|null $loadingEquipmentIdentifierId
 * @property string|null $name
 * @property int|null $segmentQuantity
 */
class StoragePlaceSize extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'storagePlaceSize';
}
