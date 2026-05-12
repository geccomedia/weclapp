<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\RecordAddress;

/**
 * @property string|null $name
 * @property string|null $description
 * @property bool|null $active
 * @property RecordAddress|null $address
 * @property string|null $email
 */
class Manufacturer extends Model {}
