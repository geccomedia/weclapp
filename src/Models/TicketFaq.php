<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property bool|null $active
 * @property string|null $answer
 * @property string|null $createdById
 * @property array|null $customers
 * @property int|null $positionNumber
 * @property string|null $question
 * @property array|null $ticketCategories
 * @property string|null $visibility
 */
class TicketFaq extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ticketFaq';
}
