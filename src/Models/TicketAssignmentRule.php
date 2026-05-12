<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $assignedPoolingGroupId
 * @property string|null $assigneeUserId
 * @property string|null $businessHolidaysId
 * @property string|null $businessHoursId
 * @property string|null $commercialLanguage
 * @property string|null $distributionChannel
 * @property array|null $parties
 * @property string|null $responsibleUserId
 * @property string|null $targetStatusId
 * @property string|null $ticketAssigneeType
 * @property string|null $ticketCategoryId
 * @property string|null $ticketChannelId
 * @property string|null $ticketPriorityId
 * @property string|null $ticketTypeId
 */
class TicketAssignmentRule extends Model
{
    /**
     * @return BelongsTo
     */
    public function assignedPoolingGroup()
    {
        return $this->belongsTo(TicketPoolingGroup::class, 'assignedPoolingGroupId');
    }

    /**
     * @return BelongsTo
     */
    public function assigneeUser()
    {
        return $this->belongsTo(User::class, 'assigneeUserId');
    }

    /**
     * @return BelongsTo
     */
    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsibleUserId');
    }

    /**
     * @return BelongsTo
     */
    public function targetStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'targetStatusId');
    }

    /**
     * @return BelongsTo
     */
    public function ticketCategory()
    {
        return $this->belongsTo(TicketCategory::class, 'ticketCategoryId');
    }

    /**
     * @return BelongsTo
     */
    public function ticketType()
    {
        return $this->belongsTo(TicketType::class, 'ticketTypeId');
    }
}
