<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\SubModels\ReminderRecurringEvent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property list<OnlyId>|null $additionalRecipients
 * @property bool|null $ccMail
 * @property string|null $entityId
 * @property string|null $entityName
 * @property Carbon|null $lastReminderSentDate
 * @property string|null $message
 * @property ReminderRecurringEvent|null $recurringEvent
 * @property Carbon|null $reminderDate
 * @property string|null $sendType
 * @property string|null $subject
 * @property string|null $userId
 */
class Reminder extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'additionalRecipients' => OnlyId::class,
        'recurringEvent' => ReminderRecurringEvent::class,
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
