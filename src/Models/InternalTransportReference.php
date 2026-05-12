<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $active
 * @property string|null $internalTransportReferenceNumber
 * @property string|null $loadingEquipmentArticleId
 * @property string|null $loadingEquipmentIdentifierId
 * @property bool|null $permanent
 * @property string|null $warehouseId
 */
class InternalTransportReference extends Model
{
    /**
     * @return BelongsTo
     */
    public function loadingEquipmentArticle()
    {
        return $this->belongsTo(Article::class, 'loadingEquipmentArticleId');
    }

    /**
     * @return BelongsTo
     */
    public function loadingEquipmentIdentifier()
    {
        return $this->belongsTo(LoadingEquipmentIdentifier::class, 'loadingEquipmentIdentifierId');
    }

    /**
     * @return BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseId');
    }

    /**
     * POST /createLabel
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createLabel(array $params = []): ?array
    {
        return $this->newQuery()->callAction('createLabel', $params, 'POST');
    }

    /**
     * GET /downloadLatestLabel
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function downloadLatestLabel(array $params = []): ?array
    {
        return $this->newQuery()->callAction('downloadLatestLabel', $params, 'GET');
    }
}
