<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdById');
    }
}
