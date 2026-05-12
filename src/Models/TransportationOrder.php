<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\TransportationOrderStatusHistory;
use Geccomedia\Weclapp\SubModels\TransportPick;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $assignedUserId
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $destinationStoragePlaceId
 * @property string|null $internalTransportReferenceId
 * @property string|null $loadingEquipmentArticleId
 * @property string|null $loadingEquipmentIdentifierId
 * @property list<TransportPick>|null $picks
 * @property string|null $productionOrderId
 * @property string|null $shipmentId
 * @property string|null $status
 * @property list<TransportationOrderStatusHistory>|null $statusHistory
 * @property string|null $transportationOrderNumber
 * @property string|null $transportationOrderType
 */
class TransportationOrder extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customAttributes' => CustomAttribute::class,
        'picks' => TransportPick::class,
        'statusHistory' => TransportationOrderStatusHistory::class,
    ];

    /**
     * @return BelongsTo
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assignedUserId');
    }

    /**
     * @return BelongsTo
     */
    public function destinationStoragePlace()
    {
        return $this->belongsTo(StoragePlace::class, 'destinationStoragePlaceId');
    }

    /**
     * @return BelongsTo
     */
    public function internalTransportReference()
    {
        return $this->belongsTo(InternalTransportReference::class, 'internalTransportReferenceId');
    }

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
    public function productionOrder()
    {
        return $this->belongsTo(ProductionOrder::class, 'productionOrderId');
    }

    /**
     * @return BelongsTo
     */
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipmentId');
    }

    /**
     * POST /addPicks
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function addPicks(array $params = []): ?array
    {
        return $this->callAction('addPicks', $params, 'POST');
    }

    /**
     * POST /createPick
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPick(array $params = []): ?array
    {
        return $this->callAction('createPick', $params, 'POST');
    }

    /**
     * POST /createPickingList
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPickingList(array $params = []): ?array
    {
        return $this->callAction('createPickingList', $params, 'POST');
    }

    /**
     * POST /createTransportationOrderFromUnpickedRecords
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createTransportationOrderFromUnpickedRecords(array $params = []): ?array
    {
        return $this->callAction('createTransportationOrderFromUnpickedRecords', $params, 'POST');
    }

    /**
     * GET /internalTransportReferencesForPickUp
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function internalTransportReferencesForPickUp(array $params = []): ?array
    {
        return $this->callAction('internalTransportReferencesForPickUp', $params, 'GET');
    }

    /**
     * POST /pickPick
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function pickPick(array $params = []): ?array
    {
        return $this->callAction('pickPick', $params, 'POST');
    }

    /**
     * POST /putDownInternalTransportReference
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function putDownInternalTransportReference(array $params = []): ?array
    {
        return $this->callAction('putDownInternalTransportReference', $params, 'POST');
    }
}
