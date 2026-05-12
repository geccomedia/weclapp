<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projectOrderStatusPage';
}
