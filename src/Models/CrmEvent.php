<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
class CrmEvent extends Model
{
    /**
     * @return BelongsTo
     */
    public function calendarEvent()
    {
        return $this->belongsTo(CalendarEvent::class, 'calendarEventId');
    }

    /**
     * @return BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Party::class, 'contactId');
    }

    /**
     * @return BelongsTo
     */
    public function creatorUser()
    {
        return $this->belongsTo(User::class, 'creatorUserId');
    }

    /**
     * @return BelongsTo
     */
    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class, 'opportunityId');
    }

    /**
     * @return BelongsTo
     */
    public function party()
    {
        return $this->belongsTo(Party::class, 'partyId');
    }
}
