<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $costCenterGroupId
 * @property string|null $costCenterNumber
 * @property string|null $costCenterType
 * @property string|null $description
 */
class CostCenter extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'costCenter';
}
