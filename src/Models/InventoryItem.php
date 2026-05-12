<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $articleId
 * @property string|null $batchNumber
 * @property string|null $comment
 * @property float|null $countedQuantity
 * @property Carbon|null $expirationDate
 * @property float|null $expectedQuantity
 * @property Carbon|null $inboundDate
 * @property string|null $inventoryId
 * @property array|null $inventorySerialNumbers
 * @property string|null $inventoryTransportReferenceId
 * @property bool|null $manualPosition
 * @property string|null $orderItemId
 * @property int|null $positionNumber
 * @property float|null $replacementValue
 * @property string|null $storagePlaceId
 */
class InventoryItem extends Model {}
