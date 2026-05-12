<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $campaignId
 * @property string|null $partyId
 * @property string|null $partyType
 * @property string|null $status
 * @property string|null $email
 * @property string|null $participation
 */
class CampaignParticipant extends Model
{
    /**
     * @return BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaignId');
    }

    /**
     * @return BelongsTo
     */
    public function party()
    {
        return $this->belongsTo(Party::class, 'partyId');
    }
}
