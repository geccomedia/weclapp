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
 * @property string|null $internalTransportReferenceId
 * @property int|null $lastModifiedDate
 * @property string|null $orderItemId
 * @property string|null $quantity
 * @property array|null $serialNumbers
 * @property string|null $sourceInternalTransportReferenceId
 * @property string|null $sourceStoragePlaceId
 * @property string|null $storagePlaceId
 * @property string|null $transportationOrderId
 */
class ItemPick extends SubModel {}
