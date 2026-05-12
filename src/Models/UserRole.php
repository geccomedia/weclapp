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
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'includedUserRoles' => OnlyId::class,
    ];

    /**
     * POST /disableUserRolesDuringTrial
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function disableUserRolesDuringTrial(array $params = []): ?array
    {
        return $this->callAction('disableUserRolesDuringTrial', $params, 'POST');
    }

    /**
     * POST /enableUserRolesDuringTrial
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function enableUserRolesDuringTrial(array $params = []): ?array
    {
        return $this->callAction('enableUserRolesDuringTrial', $params, 'POST');
    }
}
