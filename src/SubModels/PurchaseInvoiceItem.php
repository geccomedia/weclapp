<?php

namespace Geccomedia\Weclapp\SubModels;

use Geccomedia\Weclapp\SubModel;

/**
 * @property string|null $id
 * @property string|null $version
 * @property string|null $accountId
 * @property string|null $articleId
 * @property string|null $articleSupplySourceId
 * @property string|null $contractItemId
 * @property string|null $cost2CostCenterId
 * @property array|null $costCenterItems
 * @property string|null $costTypeId
 * @property int|null $createdDate
 * @property string|null $creditedInvoiceItemId
 * @property array|null $customAttributes
 * @property int|null $deliveryDate
 * @property string|null $description
 * @property bool|null $descriptionFixed
 * @property string|null $discountPercentage
 * @property string|null $grossAmount
 * @property string|null $grossAmountInCompanyCurrency
 * @property string|null $itemType
 * @property int|null $lastModifiedDate
 * @property bool|null $manualQuantity
 * @property bool|null $manualUnitPrice
 * @property string|null $netAmount
 * @property string|null $netAmountForStatistics
 * @property string|null $netAmountForStatisticsInCompanyCurrency
 * @property string|null $netAmountInCompanyCurrency
 * @property string|null $note
 * @property string|null $parentItemId
 * @property int|null $positionNumber
 * @property array|null $purchaseInvoiceItemRelationships
 * @property string|null $quantity
 * @property array|null $reductionAdditionItems
 * @property int|null $servicePeriodFromDate
 * @property int|null $servicePeriodToDate
 * @property int|null $shippingDate
 * @property string|null $taxId
 * @property string|null $title
 * @property string|null $unitId
 * @property string|null $unitPrice
 * @property string|null $unitPriceInCompanyCurrency
 */
class PurchaseInvoiceItem extends SubModel {}
