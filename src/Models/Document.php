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

    /**
     * POST /copy
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function copy(array $params = []): ?array
    {
        return $this->newQuery()->callAction('copy', $params, 'POST');
    }

    /**
     * GET /download
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function download(array $params = []): ?array
    {
        return $this->newQuery()->callAction('download', $params, 'GET');
    }

    /**
     * GET /downloadDocumentVersion
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadDocumentVersion(array $params = []): ?array
    {
        return $this->newQuery()->callAction('downloadDocumentVersion', $params, 'GET');
    }

    /**
     * GET /downloadDocumentVersionsZipped
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadDocumentVersionsZipped(array $params = []): ?array
    {
        return $this->newQuery()->callAction('downloadDocumentVersionsZipped', $params, 'GET');
    }

    /**
     * POST /upload
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function upload(array $params = []): ?array
    {
        return $this->newQuery()->callAction('upload', $params, 'POST');
    }
}
