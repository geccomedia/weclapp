<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $connectionType
 * @property string|null $name
 */
class ExternalConnection extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'externalConnection';
}
