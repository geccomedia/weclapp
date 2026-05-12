<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $quotationNumber
 * @property string|null $status
 * @property string|null $customerId
 * @property string|null $customerNumber
 * @property string|null $salesChannel
 * @property string|null $responsibleUserId
 * @property string|null $currencyId
 * @property string|null $currencyName
 * @property string|null $paymentMethodId
 * @property string|null $termOfPaymentId
 * @property string|null $note
 * @property float|null $grossAmount
 * @property float|null $netAmount
 * @property Carbon|null $quotationDate
 * @property Carbon|null $validUntilDate
 * @property array|null $quotationItems
 * @property bool|null $activeVersion
 * @property string|null $commercialLanguage
 * @property float|null $commission
 * @property array|null $commissionSalesPartners
 * @property string|null $creatorId
 * @property string|null $currencyConversionDate
 * @property bool|null $currencyConversionLocked
 * @property float|null $currencyConversionRate
 * @property array|null $customAttributes
 * @property string|null $defaultShippingCarrierId
 * @property array|null $deliveryAddress
 * @property array|null $deliveryEmailAddresses
 * @property string|null $description
 * @property bool|null $disableRecordEmailingRule
 * @property string|null $dispatchCountryCode
 * @property string|null $expectedSignatureDate
 * @property bool|null $factoring
 * @property float|null $grossAmountInCompanyCurrency
 * @property float|null $headerDiscount
 * @property float|null $headerSurcharge
 * @property array|null $invoiceAddress
 * @property string|null $invoiceRecipientId
 * @property string|null $mergedToQuotationId
 * @property float|null $netAmountInCompanyCurrency
 * @property string|null $nonStandardTaxId
 * @property string|null $opportunityId
 * @property string|null $plannedDeliveryDate
 * @property string|null $plannedShippingDate
 * @property string|null $pricingDate
 * @property string|null $publicLink
 * @property string|null $quotationType
 * @property int|null $quotationVersion
 * @property array|null $recordAddress
 * @property string|null $recordComment
 * @property bool|null $recordCommentInheritance
 * @property string|null $recordCurrencyId
 * @property array|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property bool|null $recordFreeTextInheritance
 * @property string|null $recordOpening
 * @property bool|null $recordOpeningInheritance
 * @property string|null $rejectionReason
 * @property string|null $requestDate
 * @property array|null $salesInvoiceEmailAddresses
 * @property array|null $salesOrderEmailAddresses
 * @property float|null $salesProbability
 * @property array|null $salesStageHistory
 * @property string|null $salesStageId
 * @property bool|null $sentToRecipient
 * @property string|null $servicePeriodFrom
 * @property string|null $servicePeriodTo
 * @property string|null $shipmentMethodId
 * @property array|null $shippingCostItems
 * @property array|null $statusHistory
 * @property array|null $tags
 * @property bool|null $template
 * @property string|null $validFrom
 * @property string|null $validTo
 * @property string|null $warehouseId
 */
class Quotation extends Model {}
