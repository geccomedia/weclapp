<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ticketCategory';
}
