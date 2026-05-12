<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $documentId
 * @property string|null $printStatus
 * @property string|null $printerName
 * @property int|null $quantity
 * @property string|null $userId
 * @property string|null $weclappOsHardwareId
 * @property string|null $weclappOsId
 */
class RemotePrintJob extends Model
{
    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    /**
     * @return BelongsTo
     */
    public function weclappOs()
    {
        return $this->belongsTo(WeclappOs::class, 'weclappOsId');
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'documentId');
    }

    /**
     * POST /createPrintJobWithDocument
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public static function createPrintJobWithDocument(array $params = []): ?array
    {
        return (new self)->newQuery()->action('createPrintJobWithDocument', $params, 'POST');
    }
}
