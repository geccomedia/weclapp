<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $name
 * @property string|null $description
 * @property string|null $status
 * @property string|null $customerId
 * @property string|null $customerName
 * @property string|null $responsibleUserId
 * @property string|null $responsibleUserUsername
 * @property string|null $salesStageId
 * @property string|null $salesStageName
 * @property string|null $winLossReasonId
 * @property string|null $winLossReasonName
 * @property string|null $currencyId
 * @property string|null $currencyName
 * @property string|null $salesChannel
 * @property float|null $opportunityValue
 * @property float|null $probability
 * @property Carbon|null $expectedCloseDate
 * @property string|null $contactId
 * @property string|null $creatorId
 * @property array|null $customAttributes
 * @property string|null $expectedDeliveryDate
 * @property string|null $expectedSignatureDate
 * @property bool|null $hotLead
 * @property string|null $nextCallDate
 * @property string|null $opportunityNumber
 * @property float|null $revenue
 * @property float|null $salesProbability
 * @property array|null $salesStageHistory
 * @property string|null $startDate
 * @property array|null $tags
 * @property array|null $topics
 * @property string|null $winLossDescription
 */
class Opportunity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'opportunity';
}
