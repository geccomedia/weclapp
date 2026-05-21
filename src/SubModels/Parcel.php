<?php

namespace Geccomedia\Weclapp\SubModels;

use Geccomedia\Weclapp\SubModel;

/**
 * @property string|null $id
 * @property string|null $version
 * @property int|null $createdDate
 * @property array|null $customAttributes
 * @property string|null $declaredValueAmount
 * @property string|null $declaredValueCurrencyId
 * @property bool|null $dhlGoGreenPlusService
 * @property bool|null $dhlPostalDeliveredDutyPaidService
 * @property bool|null $dhlPremiumInternationalService
 * @property int|null $height
 * @property int|null $lastModifiedDate
 * @property int|null $length
 * @property int|null $packagingWeight
 * @property int|null $positionNumber
 * @property string|null $reference
 * @property bool|null $saturdayDelivery
 * @property string|null $shippingCarrierAddition
 * @property string|null $shippingCarrierId
 * @property int|null $shippingLabelsCount
 * @property string|null $trackingId
 * @property string|null $trackingUrl
 * @property bool|null $useDeliveryDateAsPreferredDeliveryDate
 * @property int|null $weight
 * @property int|null $width
 */
class Parcel extends SubModel {}
