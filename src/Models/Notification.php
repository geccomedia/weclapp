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
    protected bool $creatable = false;

    protected bool $deletable = false;
}
