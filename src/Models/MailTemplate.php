<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $bccEmailAddresses
 * @property string|null $ccEmailAddresses
 * @property string|null $creatorId
 * @property string|null $name
 * @property string|null $subject
 * @property string|null $text
 * @property string|null $toEmailAddresses
 * @property string|null $type
 * @property bool|null $useAsDefault
 */
class MailTemplate extends Model
{
    /**
     * @return BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorId');
    }
}
