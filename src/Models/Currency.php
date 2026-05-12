<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $isoCode
 * @property string|null $name
 * @property bool|null $active
 * @property string|null $currencySymbol
 */
class Currency extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'currency';
}
