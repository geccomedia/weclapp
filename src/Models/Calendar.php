<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CalendarSharingPermissions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $caldavAccountId
 * @property string|null $calendarColor
 * @property string|null $calendarKey
 * @property list<CalendarSharingPermissions>|null $calendarSharingPermissions
 * @property string|null $lastEventsSyncToken
 * @property string|null $mailAccountId
 * @property string|null $name
 * @property string|null $ownerId
 * @property bool|null $sharePrivateEvents
 * @property bool|null $synchronize
 */
class Calendar extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'calendarSharingPermissions' => CalendarSharingPermissions::class,
    ];

    /**
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'ownerId');
    }
}
