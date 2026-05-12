<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\DocumentVersion;
use Geccomedia\Weclapp\Traits\NoCreate;
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
    use NoCreate;

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
     * POST /document/copy  or  POST /document/id/{id}/copy
     *
     * Routes to the collection endpoint when called without a persisted instance
     * (e.g. Document::copy($params)), or to the instance endpoint when called on
     * a retrieved document (e.g. $doc->copy($params)).
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function copy(array $params = []): ?array
    {
        return $this->callAction('copy', $params, 'POST');
    }

    /**
     * POST /document/upload  or  POST /document/id/{id}/upload
     *
     * Routes to the collection endpoint when called without a persisted instance
     * (e.g. Document::upload($params)), or to the instance endpoint when called
     * on a retrieved document (e.g. $doc->upload($params)).
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function upload(array $params = []): ?array
    {
        return $this->callAction('upload', $params, 'POST');
    }

    /**
     * GET /document/id/{id}/download
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function download(array $params = []): ?array
    {
        return $this->callAction('download', $params, 'GET');
    }

    /**
     * GET /document/id/{id}/downloadDocumentVersion
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadDocumentVersion(array $params = []): ?array
    {
        return $this->callAction('downloadDocumentVersion', $params, 'GET');
    }

    /**
     * GET /document/id/{id}/downloadDocumentVersionsZipped
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadDocumentVersionsZipped(array $params = []): ?array
    {
        return $this->callAction('downloadDocumentVersionsZipped', $params, 'GET');
    }
}
