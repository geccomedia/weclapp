<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $assignedUserId
 * @property array|null $customAttributes
 * @property string|null $destinationStoragePlaceId
 * @property string|null $internalTransportReferenceId
 * @property string|null $loadingEquipmentArticleId
 * @property string|null $loadingEquipmentIdentifierId
 * @property array|null $picks
 * @property string|null $productionOrderId
 * @property string|null $shipmentId
 * @property string|null $status
 * @property array|null $statusHistory
 * @property string|null $transportationOrderNumber
 * @property string|null $transportationOrderType
 */
class TransportationOrder extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transportationOrder';
}
