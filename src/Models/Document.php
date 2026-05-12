<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\DocumentVersion;
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
 * @property list<DocumentVersion>|null $versions
 */
class Document extends Model
{
    protected bool $creatable = false;

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'versions' => DocumentVersion::class,
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
