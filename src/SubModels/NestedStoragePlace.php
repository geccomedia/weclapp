<?php

namespace Geccomedia\Weclapp\SubModels;

use Geccomedia\Weclapp\SubModel;

/**
 * @property string|null $id
 * @property string|null $version
 * @property bool|null $active
 * @property string|null $barcode
 * @property bool|null $blockedForResupply
 * @property string|null $blockedForResupplyReasonId
 * @property int|null $createdDate
 * @property array|null $customAttributes
 * @property string|null $customerId
 * @property int|null $fieldNumber
 * @property int|null $lastModifiedDate
 * @property int|null $levelNumber
 * @property string|null $name
 * @property int|null $pickSequence
 * @property string|null $storagePlaceSizeId
 * @property string|null $storagePlaceType
 */
class NestedStoragePlace extends SubModel {}
