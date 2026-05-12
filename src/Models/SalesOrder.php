<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $salesOrderNumber
 * @property string|null $status
 * @property string|null $customerId
 * @property string|null $customerNumber
 * @property string|null $salesChannel
 * @property string|null $responsibleUserId
 * @property string|null $responsibleUserUsername
 * @property string|null $currencyId
 * @property string|null $currencyName
 * @property string|null $paymentMethodId
 * @property string|null $paymentMethodName
 * @property string|null $termOfPaymentId
 * @property string|null $termOfPaymentName
 * @property string|null $shippingAddressId
 * @property string|null $invoiceAddressId
 * @property string|null $warehouseId
 * @property string|null $warehouseName
 * @property string|null $shipmentMethodId
 * @property string|null $shipmentMethodName
 * @property string|null $note
 * @property string|null $internalNote
 * @property float|null $grossAmount
 * @property float|null $netAmount
 * @property float|null $openAmount
 * @property Carbon|null $orderDate
 * @property Carbon|null $deliveryDate
 * @property Carbon|null $pricingDate
 * @property Carbon|null $serviceDate
 * @property array|null $orderItems
 * @property array|null $salesOrderPaymentInfos
 * @property float|null $advancePaymentAmount
 * @property string|null $advancePaymentStatus
 * @property bool|null $applyShippingCostsOnlyOnce
 * @property string|null $cashAccountId
 * @property string|null $commercialLanguage
 * @property float|null $commission
 * @property array|null $commissionSalesPartners
 * @property string|null $creatorId
 * @property string|null $currencyConversionDate
 * @property bool|null $currencyConversionLocked
 * @property float|null $currencyConversionRate
 * @property array|null $customAttributes
 * @property string|null $customerHabitualExporterLetterOfIntentId
 * @property string|null $defaultShippingCarrierId
 * @property string|null $defaultShippingReturnCarrierId
 * @property array|null $deliveryAddress
 * @property array|null $deliveryEmailAddresses
 * @property string|null $description
 * @property bool|null $disableRecordEmailingRule
 * @property string|null $dispatchCountryCode
 * @property array|null $ecommerceOrder
 * @property bool|null $factoring
 * @property string|null $fulfillmentProviderId
 * @property float|null $grossAmountInCompanyCurrency
 * @property float|null $headerDiscount
 * @property float|null $headerSurcharge
 * @property array|null $invoiceAddress
 * @property string|null $invoiceRecipientId
 * @property bool|null $invoiced
 * @property float|null $netAmountInCompanyCurrency
 * @property string|null $nonStandardTaxId
 * @property bool|null $onlyServices
 * @property string|null $orderNumber
 * @property string|null $orderNumberAtCustomer
 * @property bool|null $paid
 * @property array|null $payments
 * @property string|null $plannedDeliveryDate
 * @property string|null $plannedProjectEndDate
 * @property string|null $plannedProjectStartDate
 * @property string|null $plannedShippingDate
 * @property string|null $projectGoals
 * @property array|null $projectMembers
 * @property bool|null $projectModeActive
 * @property string|null $quotationId
 * @property array|null $recordAddress
 * @property string|null $recordAsn
 * @property string|null $recordComment
 * @property bool|null $recordCommentInheritance
 * @property string|null $recordCurrencyId
 * @property array|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property bool|null $recordFreeTextInheritance
 * @property string|null $recordOpening
 * @property bool|null $recordOpeningInheritance
 * @property array|null $salesInvoiceEmailAddresses
 * @property string|null $salesOrderPaymentType
 * @property bool|null $sentToRecipient
 * @property string|null $sepaDirectDebitMandateId
 * @property string|null $servicePeriodFrom
 * @property string|null $servicePeriodTo
 * @property bool|null $servicesFinished
 * @property bool|null $shipped
 * @property array|null $shippingCostItems
 * @property int|null $shippingLabelsCount
 * @property array|null $statusHistory
 * @property array|null $tags
 * @property bool|null $template
 */
class SalesOrder extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'salesOrder';
}
