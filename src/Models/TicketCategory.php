<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $active
 * @property array|null $customerPortals
 * @property string|null $name
 * @property string|null $parentTicketCategoryId
 * @property bool|null $pseudoCategory
 * @property bool|null $published
 * @property bool|null $visibleInCustomerPortal
 */
class TicketCategory extends Model
{
    /**
     * @return BelongsTo
     */
    public function parentTicketCategory()
    {
        return $this->belongsTo(TicketCategory::class, 'parentTicketCategoryId');
    }
}
