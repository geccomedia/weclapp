<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $commentsVisible
 * @property bool|null $createComments
 * @property bool|null $displayAllTeamMembers
 * @property bool|null $documentsVisible
 * @property bool|null $mainTasksVisible
 * @property string|null $name
 * @property string|null $plannedWorkVisibility
 * @property string|null $projectOrderId
 * @property string|null $projectStatusPageUrl
 * @property string|null $realizedWorkVisibility
 * @property bool|null $subTasksVisible
 * @property bool|null $ticketsVisible
 * @property bool|null $uploadDocument
 */
class ProjectOrderStatusPage extends Model
{
    /**
     * @return BelongsTo
     */
    public function projectOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'projectOrderId');
    }
}
