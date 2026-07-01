<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\ApproverStatus;
use Geccomedia\Weclapp\Traits\IsReadOnly;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $active
 * @property list<ApproverStatus>|null $approverStatuses
 * @property string|null $currentApproverStatusId
 * @property string|null $currentStatusType
 * @property string|null $entityId
 * @property string|null $entityName
 * @property string|null $requesterId
 * @property string|null $ruleId
 */
class Approval extends Model
{
    use IsReadOnly;

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'approverStatuses' => ApproverStatus::class,
    ];

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requesterId');
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(ApprovalRule::class, 'ruleId');
    }

    /**
     * POST /changeStatus
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function changeStatus(array $params = []): ?array
    {
        return $this->callAction('changeStatus', $params, 'POST');
    }
}
