<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CalendarEventAttendee;
use Geccomedia\Weclapp\SubModels\EntityReference;
use Geccomedia\Weclapp\SubModels\RecurringEvent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $allDayEvent
 * @property list<CalendarEventAttendee>|null $attendees
 * @property string|null $calendarId
 * @property string|null $concerningId
 * @property string|null $contactId
 * @property bool|null $deleted
 * @property string|null $description
 * @property Carbon|null $endDate
 * @property string|null $location
 * @property bool|null $privateEvent
 * @property RecurringEvent|null $recurringEvent
 * @property list<EntityReference>|null $references
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
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'attendees' => CalendarEventAttendee::class,
        'recurringEvent' => RecurringEvent::class,
        'references' => EntityReference::class,
    ];

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
