<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $batchNumber
 * @property Carbon|null $bookedDate
 * @property string|null $confirmedByUserId
 * @property Carbon|null $confirmedDate
 * @property string|null $internalTransportReferenceId
 * @property string|null $orderItemId
 * @property string|null $packagingUnitBaseArticleId
 * @property int|null $positionNumber
 * @property string|null $productionOrderItemId
 * @property float|null $quantity
 * @property string|null $salesOrderItemId
 * @property array|null $serialNumbers
 * @property string|null $shipmentItemId
 * @property string|null $sourceInternalTransportReferenceId
 * @property string|null $sourceStoragePlaceId
 * @property string|null $storagePlaceId
 * @property string|null $transportationOrderId
 */
class Pick extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pick';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'bookedDate' => 'datetime',
        'confirmedDate' => 'datetime',
        'createdDate' => 'datetime',
        'lastModifiedDate' => 'datetime',
    ];
}
