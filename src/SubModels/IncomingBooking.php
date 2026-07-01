<?php

namespace Geccomedia\Weclapp\SubModels;

use Geccomedia\Weclapp\SubModel;

/**
 * @property string|null $id
 * @property string|null $version
 * @property string|null $articleValuationPrice
 * @property string|null $batchNumber
 * @property bool|null $bookIntoWarehouse
 * @property string|null $confirmedByUserId
 * @property string|null $confirmedByUserIdDeprecated
 * @property int|null $confirmedDate
 * @property int|null $confirmedDateDeprecated
 * @property string|null $confirmedQuantityDeprecated
 * @property int|null $createdDate
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $ddsNumber
 * @property int|null $expirationDate
 * @property string|null $incomingGoodsItemId
 * @property string|null $internalTransportReferenceId
 * @property int|null $lastModifiedDate
 * @property string|null $loadingEquipmentIdentifierId
 * @property string|null $quantity
 * @property array|null $serialNumbers
 * @property string|null $storagePlaceId
 */
class IncomingBooking extends SubModel {}
