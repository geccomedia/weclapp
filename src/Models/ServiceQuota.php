<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $articleId
 * @property int|null $billableQuantitySeconds
 * @property array|null $customAttributes
 * @property string|null $customerId
 * @property string|null $description
 * @property string|null $name
 * @property int|null $quantitySeconds
 * @property string|null $serviceQuotaNumber
 * @property array|null $serviceQuotaRelationships
 * @property string|null $status
 * @property array|null $statusHistory
 * @property Carbon|null $validFromDate
 * @property Carbon|null $validUntilDate
 */
class ServiceQuota extends Model {}
