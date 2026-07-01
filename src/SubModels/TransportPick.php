<?php

namespace Geccomedia\Weclapp\SubModels;

use Geccomedia\Weclapp\SubModel;

/**
 * @property string|null $id
 * @property string|null $version
 * @property string|null $batchNumber
 * @property int|null $bookedDate
 * @property string|null $confirmedByUserId
 * @property int|null $confirmedDate
 * @property int|null $createdDate
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $internalTransportReferenceId
 * @property int|null $lastModifiedDate
 * @property string|null $orderItemId
 * @property string|null $packagingUnitBaseArticleId
 * @property int|null $positionNumber
 * @property string|null $productionOrderItemId
 * @property string|null $quantity
 * @property string|null $salesOrderItemId
 * @property array|null $serialNumbers
 * @property string|null $shipmentItemId
 * @property string|null $sourceInternalTransportReferenceId
 * @property string|null $sourceStoragePlaceId
 * @property string|null $storagePlaceId
 */
class TransportPick extends SubModel {}
