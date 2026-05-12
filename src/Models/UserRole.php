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
class UserRole extends Model
{
    /**
     * POST /disableUserRolesDuringTrial
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public static function disableUserRolesDuringTrial(array $params = []): ?array
    {
        return (new self)->newQuery()->action('disableUserRolesDuringTrial', $params, 'POST');
    }

    /**
     * POST /enableUserRolesDuringTrial
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public static function enableUserRolesDuringTrial(array $params = []): ?array
    {
        return (new self)->newQuery()->action('enableUserRolesDuringTrial', $params, 'POST');
    }
}
