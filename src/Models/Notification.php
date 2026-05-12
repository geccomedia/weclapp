<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $description
 * @property string|null $entityId
 * @property string|null $entityName
 * @property string|null $priority
 * @property bool|null $read
 * @property string|null $title
 */
class Notification extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notification';
}
