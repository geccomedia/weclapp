<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property bool|null $atCreate
 * @property bool|null $atDelete
 * @property bool|null $atUpdate
 * @property Carbon|null $deactivatedDate
 * @property string|null $entityName
 * @property string|null $errorMessage
 * @property string|null $requestMethod
 * @property string|null $url
 */
class Webhook extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'webhook';
}
