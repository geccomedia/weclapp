<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $name
 * @property string|null $description
 * @property string|null $trackingUrlTemplate
 * @property bool|null $active
 * @property string|null $fulfillmentProviderType
 * @property string|null $warehouseId
 */
class FulfillmentProvider extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fulfillmentProvider';
}
