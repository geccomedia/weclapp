<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $caldavAccountId
 * @property string|null $calendarColor
 * @property string|null $calendarKey
 * @property array|null $calendarSharingPermissions
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
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'ownerId');
    }
}
