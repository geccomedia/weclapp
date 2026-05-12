<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\ProductionWorkScheduleItem;

/**
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $description
 * @property string|null $status
 * @property list<ProductionWorkScheduleItem>|null $workScheduleItems
 * @property string|null $workScheduleNumber
 */
class ProductionWorkSchedule extends Model {}
