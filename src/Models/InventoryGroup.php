<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\Traits\IsReadOnly;

/**
 * @property string|null $name
 */
class InventoryGroup extends Model
{
    use IsReadOnly;
}
