<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $active
 * @property string|null $answer
 * @property string|null $createdById
 * @property list<OnlyId>|null $customers
 * @property int|null $positionNumber
 * @property string|null $question
 * @property list<OnlyId>|null $ticketCategories
 * @property string|null $visibility
 */
class TicketFaq extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customers' => OnlyId::class,
        'ticketCategories' => OnlyId::class,
    ];

    /**
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdById');
    }
}
