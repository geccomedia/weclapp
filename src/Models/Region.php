<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $countryCode
 * @property string|null $description
 * @property string|null $matchCode
 * @property string|null $name
 * @property string|null $responsibleUserId
 */
class Region extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'region';
}
