<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property array|null $customAttributes
 * @property string|null $description
 * @property string|null $status
 * @property array|null $workScheduleItems
 * @property string|null $workScheduleNumber
 */
class ProductionWorkSchedule extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'productionWorkSchedule';
}
