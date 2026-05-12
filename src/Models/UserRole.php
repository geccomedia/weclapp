<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property bool|null $allPermissionsEnabled
 * @property array|null $includedUserRoles
 * @property string|null $name
 * @property array|null $permissions
 */
class UserRole extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'userRole';
}
