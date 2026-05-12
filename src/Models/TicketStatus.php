<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $autoChangeDays
 * @property string|null $autoChangeTicketStatusId
 * @property string|null $color
 * @property bool|null $defaultForInternal
 * @property string|null $internalTicketStatus
 * @property string|null $name
 * @property int|null $positionNumber
 * @property string|null $targetStatusId
 */
class TicketStatus extends Model
{
    /**
     * @return BelongsTo
     */
    public function autoChangeTicketStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'autoChangeTicketStatusId');
    }

    /**
     * @return BelongsTo
     */
    public function targetStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'targetStatusId');
    }
}
