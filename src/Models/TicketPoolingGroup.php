<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\SubModels\TicketPoolingGroupMember;
use Geccomedia\Weclapp\Traits\IsReadOnly;

/**
 * @property string|null $description
 * @property string|null $name
 * @property list<OnlyId>|null $ticketCategories
 * @property list<TicketPoolingGroupMember>|null $ticketPoolingGroupMembers
 */
class TicketPoolingGroup extends Model
{
    use IsReadOnly;

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'ticketCategories' => OnlyId::class,
        'ticketPoolingGroupMembers' => TicketPoolingGroupMember::class,
    ];
}
