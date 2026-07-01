<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\Approver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $active
 * @property list<Approver>|null $approvers
 * @property string|null $conditionAmount
 * @property string|null $conditionType
 * @property string|null $event
 * @property string|null $name
 * @property string|null $requesterGroupId
 * @property string|null $requesterPersonId
 */
class ApprovalRule extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'approvers' => Approver::class,
    ];

    public function requesterGroup(): BelongsTo
    {
        return $this->belongsTo(ApprovalGroup::class, 'requesterGroupId');
    }

    public function requesterPerson(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requesterPersonId');
    }
}
