<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property bool|null $active
 * @property string|null $barcode
 * @property bool|null $blockedForResupply
 * @property string|null $blockedForResupplyReasonId
 * @property string|null $currentInventoryId
 * @property array|null $customAttributes
 * @property string|null $customerId
 * @property int|null $fieldNumber
 * @property int|null $levelNumber
 * @property string|null $name
 * @property string|null $shelfId
 * @property string|null $shelfStorageLocationId
 * @property string|null $storageLocationId
 * @property string|null $storagePlaceSizeId
 * @property string|null $storagePlaceType
 * @property string|null $warehouseId
 */
class StoragePlace extends Model {}
