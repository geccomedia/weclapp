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
class User extends Model {}
