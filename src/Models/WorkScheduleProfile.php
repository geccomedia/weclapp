<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\WorkScheduleDay;

/**
 * @property string|null $description
 * @property string|null $name
 * @property string|null $type
 * @property int|null $weeklyWorkDays
 * @property int|null $weeklyWorkDurationInMinutes
 * @property list<WorkScheduleDay>|null $workScheduleDays
 */
class WorkScheduleProfile extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'workScheduleDays' => WorkScheduleDay::class,
    ];
}
