<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $name
 * @property string|null $description
 * @property string|null $status
 * @property string|null $campaignType
 * @property string|null $responsibleUserId
 * @property string|null $responsibleUserUsername
 * @property float|null $budget
 * @property float|null $actualCosts
 * @property Carbon|null $startDate
 * @property Carbon|null $endDate
 * @property string|null $campaignEndDate
 * @property string|null $campaignName
 * @property string|null $campaignNumber
 * @property string|null $campaignStartDate
 * @property array|null $customAttributes
 */
class Campaign extends Model {}
