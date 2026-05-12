<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $name
 * @property string|null $description
 * @property string|null $warehouseType
 * @property bool|null $active
 * @property array|null $customAttributes
 * @property string|null $defaultConsolidationStoragePlaceId
 * @property string|null $defaultProductionStoragePlaceId
 * @property string|null $defaultReturnsStoragePlaceId
 * @property string|null $defaultStoragePlaceId
 * @property array|null $deliveryAddress
 * @property string|null $directBookingInternalTransportReferenceId
 * @property array|null $invoiceAddress
 * @property string|null $loadingEquipmentStoragePlace
 * @property array|null $primaryAddress
 * @property string|null $shortIdentifier
 * @property bool|null $standard
 * @property string|null $transitStoragePlace
 */
class Warehouse extends Model {}
