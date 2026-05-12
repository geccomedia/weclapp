<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $tariffNumber
 * @property string|null $description
 * @property bool|null $active
 * @property string|null $name
 * @property int|null $positionNumber
 */
class CustomsTariffNumber extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customsTariffNumber';
}
