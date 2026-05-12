<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $name
 * @property string|null $responsibleUserId
 * @property string|null $visibilityType
 */
class TaskList extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'taskList';
}
