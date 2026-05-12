<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property array|null $additionalAddresses
 * @property string|null $authorizationUnitId
 * @property bool|null $automaticExtension
 * @property string|null $billUntil
 * @property int|null $billingDay
 * @property string|null $billingTargetInvoiceStatus
 * @property string|null $billingType
 * @property Carbon|null $cancellationDate
 * @property int|null $cancellationPeriodQuantity
 * @property int|null $cancellationPeriodSoftframe
 * @property string|null $cancellationPeriodUnit
 * @property string|null $commercialLanguage
 * @property float|null $commission
 * @property array|null $commissionSalesPartners
 * @property array|null $contractCostItems
 * @property Carbon|null $contractDate
 * @property array|null $contractItems
 * @property string|null $contractNumber
 * @property string|null $contractNumberAtParty
 * @property string|null $contractStatus
 * @property array|null $correspondenceAddress
 * @property string|null $creatorId
 * @property array|null $customAttributes
 * @property array|null $deliveryAddress
 * @property array|null $deliveryEmailAddresses
 * @property string|null $depositLocationId
 * @property string|null $description
 * @property string|null $desiredSalesOrderStatus
 * @property bool|null $differingCorrespondenceAddress
 * @property bool|null $differingDeliveryAddress
 * @property bool|null $differingInvoiceAddress
 * @property bool|null $disableRecordEmailingRule
 * @property Carbon|null $endDate
 * @property int|null $extensionQuantity
 * @property string|null $extensionUnit
 * @property bool|null $factoring
 * @property string|null $formVariantId
 * @property array|null $invoiceAddress
 * @property string|null $invoiceRecipientId
 * @property int|null $latestCancellationWarningQuantity
 * @property string|null $latestCancellationWarningUnit
 * @property Carbon|null $latestPossibleTerminationDate
 * @property string|null $name
 * @property Carbon|null $nextContractBillingDate
 * @property string|null $nonStandardInputTaxId
 * @property string|null $nonStandardTaxId
 * @property string|null $orderNumberAtCustomer
 * @property string|null $organizationId
 * @property string|null $partyId
 * @property string|null $paymentMethodId
 * @property Carbon|null $pricingDate
 * @property array|null $purchaseEmailAddresses
 * @property string|null $recordComment
 * @property string|null $recordCurrencyId
 * @property array|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property string|null $recordOpening
 * @property Carbon|null $reminderDate
 * @property string|null $reminderSendType
 * @property string|null $reminderType
 * @property string|null $responsibleUserId
 * @property string|null $salesChannel
 * @property array|null $salesInvoiceEmailAddresses
 * @property array|null $salesOrderEmailAddresses
 * @property bool|null $sentToRecipient
 * @property Carbon|null $startDate
 * @property array|null $tags
 * @property string|null $technicalContactPersonId
 * @property bool|null $template
 * @property string|null $termOfPaymentId
 * @property string|null $terminationReasonId
 * @property string|null $ticketServiceLevelAgreementId
 * @property array|null $types
 * @property bool|null $unlimited
 */
class Contract extends Model {}
