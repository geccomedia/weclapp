<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\OnlyId;

/**
 * @property bool|null $allPermissionsEnabled
 * @property list<OnlyId>|null $includedUserRoles
 * @property string|null $name
 * @property array|null $permissions
 */
class UserRole extends Model {}
