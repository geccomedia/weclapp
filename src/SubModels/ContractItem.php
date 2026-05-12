<?php

namespace Geccomedia\Weclapp\SubModels;

use Geccomedia\Weclapp\SubModel;

/**
 * @property string|null $id
 * @property string|null $version
 * @property bool|null $addPageBreakBefore
 * @property string|null $articleId
 * @property string|null $billingGroupId
 * @property array|null $commissionSalesPartners
 * @property array|null $costCenterItems
 * @property string|null $costTypeId
 * @property int|null $createdDate
 * @property array|null $customAttributes
 * @property string|null $description
 * @property bool|null $descriptionFixed
 * @property string|null $discountPercentage
 * @property string|null $grossAmount
 * @property string|null $grossAmountInCompanyCurrency
 * @property string|null $groupName
 * @property string|null $interval
 * @property string|null $intervalType
 * @property string|null $itemType
 * @property int|null $lastModifiedDate
 * @property bool|null $manualQuantity
 * @property bool|null $manualUnitPrice
 * @property string|null $netAmount
 * @property string|null $netAmountForStatistics
 * @property string|null $netAmountForStatisticsInCompanyCurrency
 * @property string|null $netAmountInCompanyCurrency
 * @property int|null $nextContractBillingDate
 * @property string|null $note
 * @property string|null $parentItemId
 * @property int|null $positionNumber
 * @property int|null $previousContractBillingDate
 * @property string|null $quantity
 * @property array|null $reductionAdditionItems
 * @property int|null $servicePeriodFromDate
 * @property int|null $servicePeriodToDate
 * @property string|null $taxId
 * @property string|null $title
 * @property string|null $type
 * @property string|null $unitId
 * @property string|null $unitPrice
 * @property string|null $unitPriceInCompanyCurrency
 */
class ContractItem extends SubModel {}
