<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $countryCode
 * @property string|null $description
 * @property string|null $matchCode
 * @property string|null $name
 * @property string|null $responsibleUserId
 */
class Region extends Model
{
    /**
     * @return BelongsTo
     */
    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsibleUserId');
    }
}
