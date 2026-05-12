<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\OnlyId;

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
    protected bool $deletable = false;

    /**
     * POST /deleteMfaDevice
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function deleteMfaDevice(array $params = []): ?array
    {
        return $this->newQuery()->callAction('deleteMfaDevice', $params, 'POST');
    }

    /**
     * POST /invite
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function invite(array $params = []): ?array
    {
        return $this->newQuery()->callAction('invite', $params, 'POST');
    }

    /**
     * GET /readMfaDevices
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function readMfaDevices(array $params = []): ?array
    {
        return $this->newQuery()->callAction('readMfaDevices', $params, 'GET');
    }

    /**
     * POST /softDelete
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function softDelete(array $params = []): ?array
    {
        return $this->newQuery()->callAction('softDelete', $params, 'POST');
    }

    /**
     * GET /userImage
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function userImage(array $params = []): ?array
    {
        return $this->newQuery()->callAction('userImage', $params, 'GET');
    }

    /**
     * GET /userImageThumbnail
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function userImageThumbnail(array $params = []): ?array
    {
        return $this->newQuery()->callAction('userImageThumbnail', $params, 'GET');
    }

    /**
     * GET /currentUser
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public static function currentUser(array $params = []): ?array
    {
        return (new self)->newQuery()->action('currentUser', $params, 'GET');
    }
}
