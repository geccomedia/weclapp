<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $calendarEventId
 * @property string|null $callCategoryId
 * @property string|null $contactId
 * @property string|null $creatorUserId
 * @property array|null $customAttributes
 * @property string|null $description
 * @property Carbon|null $endDate
 * @property string|null $eventCategoryId
 * @property string|null $location
 * @property string|null $opportunityId
 * @property string|null $partyId
 * @property Carbon|null $startDate
 * @property string|null $subject
 * @property array|null $tags
 * @property string|null $type
 */
class CrmEvent extends Model {}
