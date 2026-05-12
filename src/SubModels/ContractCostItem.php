<?php

namespace Geccomedia\Weclapp\SubModels;

use Geccomedia\Weclapp\SubModel;

/**
 * @property string|null $id
 * @property string|null $version
 * @property string|null $articleId
 * @property int|null $createdDate
 * @property string|null $description
 * @property bool|null $descriptionFixed
 * @property string|null $discountPercentage
 * @property string|null $interval
 * @property string|null $intervalType
 * @property int|null $lastModifiedDate
 * @property bool|null $manualUnitPrice
 * @property string|null $netAmount
 * @property string|null $netAmountInCompanyCurrency
 * @property string|null $note
 * @property string|null $quantity
 * @property int|null $servicePeriodFrom
 * @property int|null $servicePeriodTo
 * @property string|null $title
 * @property string|null $unitId
 * @property string|null $unitPrice
 * @property string|null $unitPriceInCompanyCurrency
 */
class ContractCostItem extends SubModel {}
