<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $name
 * @property string|null $description
 * @property string|null $entityName
 * @property string|null $entityId
 * @property string|null $fileSize
 * @property string|null $mimeType
 * @property string|null $fileHash
 * @property bool|null $external
 * @property Carbon|null $documentDate
 * @property int|null $documentSize
 * @property string|null $documentType
 * @property string|null $mediaType
 * @property string|null $userId
 * @property array|null $versions
 */
class Document extends Model
{
    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
