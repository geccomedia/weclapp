<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\OnlyId;

/**
 * @property string|null $description
 * @property list<OnlyId>|null $members
 * @property string|null $name
 */
class ApprovalGroup extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'members' => OnlyId::class,
    ];
}
