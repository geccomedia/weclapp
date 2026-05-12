<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $name
 * @property string|null $description
 * @property bool|null $active
 * @property int|null $positionNumber
 */
class OpportunityWinLossReason extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'opportunityWinLossReason';
}
