<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property bool|null $active
 * @property array|null $categories
 * @property array|null $customers
 * @property float|null $degreeOfPerformance
 * @property bool|null $includeNoTicketType
 * @property string|null $name
 * @property string|null $ratingId
 * @property array|null $targets
 * @property array|null $types
 * @property bool|null $visible
 */
class TicketServiceLevelAgreement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ticketServiceLevelAgreement';
}
