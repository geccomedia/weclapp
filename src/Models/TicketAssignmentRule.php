<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ticketAssignmentRule';
}
