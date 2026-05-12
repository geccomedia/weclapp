<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $description
 * @property string|null $name
 * @property array|null $ticketCategories
 * @property array|null $ticketPoolingGroupMembers
 */
class TicketPoolingGroup extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ticketPoolingGroup';
}
