<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $name
 * @property string|null $description
 * @property float|null $probability
 * @property bool|null $active
 */
class SalesStage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'salesStage';
}
