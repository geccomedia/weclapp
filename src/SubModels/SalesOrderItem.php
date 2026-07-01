<?php

namespace Geccomedia\Weclapp\SubModels;

use Geccomedia\Weclapp\SubModel;

/**
 * @property string|null $id
 * @property string|null $version
 * @property bool|null $addPageBreakBefore
 * @property string|null $articleId
 * @property array|null $commissionSalesPartners
 * @property string|null $contractChargeId
 * @property list<CostCenterWithDistributionPercentage>|null $costCenterItems
 * @property int|null $createdDate
 * @property array|null $customAttributes
 * @property string|null $description
 * @property bool|null $descriptionFixed
 * @property string|null $discountPercentage
 * @property array|null $ecommerceOrderItemIds
 * @property string|null $grossAmount
 * @property string|null $grossAmountInCompanyCurrency
 * @property string|null $groupName
 * @property string|null $invoicedQuantity
 * @property string|null $invoicingType
 * @property string|null $itemType
 * @property int|null $lastModifiedDate
 * @property bool|null $manualPlannedWorkingTimePerUnit
 * @property bool|null $manualQuantity
 * @property bool|null $manualUnitCost
 * @property bool|null $manualUnitPrice
 * @property string|null $netAmount
 * @property string|null $netAmountForStatistics
 * @property string|null $netAmountForStatisticsInCompanyCurrency
 * @property string|null $netAmountInCompanyCurrency
 * @property string|null $note
 * @property string|null $parentItemId
 * @property array|null $picks
 * @property int|null $plannedDeliveryDate
 * @property int|null $plannedShippingDate
 * @property int|null $plannedWorkingTimePerUnit
 * @property int|null $positionNumber
 * @property string|null $quantity
 * @property string|null $recommendedRetailPrice
 * @property array|null $reductionAdditionItems
 * @property string|null $returnedQuantity
 * @property int|null $servicePeriodFrom
 * @property int|null $servicePeriodTo
 * @property string|null $serviceQuotaId
 * @property bool|null $shipped
 * @property string|null $shippedQuantity
 * @property array|null $tasks
 * @property string|null $taxId
 * @property string|null $title
 * @property string|null $unitCost
 * @property string|null $unitCostInCompanyCurrency
 * @property string|null $unitId
 * @property string|null $unitPrice
 * @property string|null $unitPriceInCompanyCurrency
 */
class SalesOrderItem extends SubModel {}
