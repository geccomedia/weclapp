<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\SubModels\TicketServiceLevelAgreementTarget;

/**
 * @property bool|null $active
 * @property list<OnlyId>|null $categories
 * @property list<OnlyId>|null $customers
 * @property float|null $degreeOfPerformance
 * @property bool|null $includeNoTicketType
 * @property string|null $name
 * @property string|null $ratingId
 * @property list<TicketServiceLevelAgreementTarget>|null $targets
 * @property list<OnlyId>|null $types
 * @property bool|null $visible
 */
class TicketServiceLevelAgreement extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'categories' => OnlyId::class,
        'customers' => OnlyId::class,
        'targets' => TicketServiceLevelAgreementTarget::class,
        'types' => OnlyId::class,
    ];
}
