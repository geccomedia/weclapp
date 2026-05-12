<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\Traits\NoDelete;

/**
 * @property string|null $username
 * @property string|null $email
 * @property string|null $firstName
 * @property string|null $lastName
 * @property string|null $salutation
 * @property string|null $phone
 * @property string|null $mobilePhone1
 * @property string|null $status
 * @property string|null $userType
 * @property bool|null $active
 * @property string|null $birthDate
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $faxNumber
 * @property string|null $imageId
 * @property array|null $licenses
 * @property string|null $mobilePhoneNumber
 * @property string|null $phoneNumber
 * @property string|null $title
 * @property list<OnlyId>|null $userRoles
 */
class User extends Model
{
    use NoDelete;

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customAttributes' => CustomAttribute::class,
        'userRoles' => OnlyId::class,
    ];

    /**
     * POST /deleteMfaDevice
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function deleteMfaDevice(array $params = []): ?array
    {
        return $this->callAction('deleteMfaDevice', $params, 'POST');
    }

    /**
     * POST /invite
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function invite(array $params = []): ?array
    {
        return $this->callAction('invite', $params, 'POST');
    }

    /**
     * GET /readMfaDevices
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function readMfaDevices(array $params = []): ?array
    {
        return $this->callAction('readMfaDevices', $params, 'GET');
    }

    /**
     * POST /softDelete
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function softDelete(array $params = []): ?array
    {
        return $this->callAction('softDelete', $params, 'POST');
    }

    /**
     * GET /userImage
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function userImage(array $params = []): ?array
    {
        return $this->callAction('userImage', $params, 'GET');
    }

    /**
     * GET /userImageThumbnail
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function userImageThumbnail(array $params = []): ?array
    {
        return $this->callAction('userImageThumbnail', $params, 'GET');
    }

    /**
     * GET /currentUser
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function currentUser(array $params = []): ?array
    {
        return $this->callAction('currentUser', $params, 'GET');
    }
}
