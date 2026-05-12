<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $active
 * @property list<OnlyId>|null $customerPortals
 * @property string|null $name
 * @property string|null $parentTicketCategoryId
 * @property bool|null $pseudoCategory
 * @property bool|null $published
 * @property bool|null $visibleInCustomerPortal
 */
class TicketCategory extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customerPortals' => OnlyId::class,
    ];

    /**
     * @return BelongsTo
     */
    public function parentTicketCategory()
    {
        return $this->belongsTo(TicketCategory::class, 'parentTicketCategoryId');
    }
}
