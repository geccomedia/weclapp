<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $allDayEvent
 * @property array|null $attendees
 * @property string|null $calendarId
 * @property string|null $concerningId
 * @property string|null $contactId
 * @property bool|null $deleted
 * @property string|null $description
 * @property Carbon|null $endDate
 * @property string|null $location
 * @property bool|null $privateEvent
 * @property array|null $recurringEvent
 * @property array|null $references
 * @property string|null $reminderSendType
 * @property int|null $reminderTime
 * @property string|null $showAs
 * @property Carbon|null $startDate
 * @property string|null $subject
 * @property string|null $userId
 */
class CalendarEvent extends Model
{
    /**
     * @return BelongsTo
     */
    public function calendar()
    {
        return $this->belongsTo(Calendar::class, 'calendarId');
    }

    /**
     * @return BelongsTo
     */
    public function concerning()
    {
        return $this->belongsTo(Party::class, 'concerningId');
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
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
