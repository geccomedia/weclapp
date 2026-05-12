<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $partyType
 * @property string|null $salutation
 * @property string|null $company
 * @property string|null $firstName
 * @property string|null $lastName
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $fax
 * @property string|null $mobilePhone1
 * @property string|null $website
 * @property string|null $customerNumber
 * @property string|null $oldCustomerNumber
 * @property string|null $description
 * @property string|null $currencyId
 * @property string|null $currencyName
 * @property string|null $paymentMethodId
 * @property string|null $paymentMethodName
 * @property string|null $termOfPaymentId
 * @property string|null $termOfPaymentName
 * @property string|null $primaryContactId
 * @property string|null $invoiceContactId
 * @property string|null $deliveryAddressId
 * @property string|null $invoiceAddressId
 * @property string|null $responsibleUserId
 * @property string|null $responsibleUserUsername
 * @property string|null $salesChannel
 * @property string|null $vatRegistrationNumber
 * @property bool|null $insolvent
 * @property bool|null $shipmentRatingActive
 * @property array|null $addresses
 * @property array|null $contacts
 * @property array|null $bankAccounts
 * @property array|null $topics
 * @property array|null $customerCategories
 * @property string|null $birthDate
 * @property string|null $commercialLanguageId
 * @property bool|null $commissionBlock
 * @property array|null $commissionSalesPartners
 * @property string|null $company2
 * @property string|null $companySizeId
 * @property bool|null $competitor
 * @property string|null $convertedOnDate
 * @property array|null $customAttributes
 * @property bool|null $customer
 * @property bool|null $customerAllowDropshippingOrderCreation
 * @property float|null $customerAmountInsured
 * @property float|null $customerAnnualRevenue
 * @property string|null $customerBlockNotice
 * @property bool|null $customerBlocked
 * @property string|null $customerBusinessType
 * @property string|null $customerCategoryId
 * @property float|null $customerCreditLimit
 * @property string|null $customerCurrentSalesStageId
 * @property string|null $customerDebtorAccountId
 * @property string|null $customerDebtorAccountingCodeId
 * @property float|null $customerDefaultHeaderDiscount
 * @property float|null $customerDefaultHeaderSurcharge
 * @property string|null $customerDefaultShippingCarrierId
 * @property string|null $customerDefaultWarehouseId
 * @property bool|null $customerDeliveryBlock
 * @property bool|null $customerInsolvent
 * @property bool|null $customerInsured
 * @property string|null $customerInternalNote
 * @property string|null $customerLossDescription
 * @property string|null $customerLossReasonId
 * @property string|null $customerNonStandardTaxId
 * @property string|null $customerNumberOld
 * @property string|null $customerPaymentMethodId
 * @property string|null $customerSalesChannel
 * @property string|null $customerSalesOrderPaymentType
 * @property float|null $customerSalesProbability
 * @property array|null $customerSalesStageHistory
 * @property string|null $customerSatisfaction
 * @property string|null $customerShipmentMethodId
 * @property string|null $customerSupplierNumber
 * @property string|null $customerTermOfPaymentId
 * @property bool|null $customerUseCustomsTariffNumber
 * @property string|null $deliveryEmailAddressesId
 * @property string|null $dunningAddressId
 * @property string|null $dunningEmailAddressesId
 * @property string|null $emailHome
 * @property bool|null $enableDropshippingInNewSupplySources
 * @property string|null $eoriNumber
 * @property bool|null $factoring
 * @property string|null $fixPhone2
 * @property bool|null $fixedResponsibleUser
 * @property bool|null $formerSalesPartner
 * @property bool|null $habitualExporter
 * @property string|null $imageId
 * @property bool|null $invoiceBlock
 * @property string|null $invoiceRecipientId
 * @property string|null $leadRatingId
 * @property string|null $leadSourceId
 * @property string|null $leadStatus
 * @property string|null $legalFormId
 * @property string|null $middleName
 * @property string|null $mobilePhone2
 * @property array|null $onlineAccounts
 * @property bool|null $optInEmail
 * @property bool|null $optInLetter
 * @property bool|null $optInPhone
 * @property bool|null $optInSms
 * @property string|null $parentPartyId
 * @property array|null $partyEmailAddresses
 * @property array|null $partyHabitualExporterLettersOfIntent
 * @property string|null $personCompany
 * @property string|null $personDepartmentId
 * @property string|null $personRoleId
 * @property string|null $phoneHome
 * @property string|null $primaryAddressId
 * @property string|null $publicPageExpirationDate
 * @property string|null $publicPageUuid
 * @property string|null $purchaseEmailAddressesId
 * @property bool|null $purchaseViaPlafond
 * @property string|null $quotationEmailAddressesId
 * @property string|null $ratingId
 * @property string|null $referenceNumber
 * @property string|null $regionId
 * @property string|null $salesInvoiceEmailAddressesId
 * @property string|null $salesOrderEmailAddressesId
 * @property bool|null $salesPartner
 * @property float|null $salesPartnerDefaultCommissionFix
 * @property float|null $salesPartnerDefaultCommissionPercentage
 * @property string|null $salesPartnerDefaultCommissionType
 * @property string|null $sectorId
 * @property bool|null $supplier
 * @property bool|null $supplierActive
 * @property string|null $supplierCreditorAccountId
 * @property string|null $supplierCreditorAccountingCodeId
 * @property string|null $supplierCustomerNumberAtSupplier
 * @property string|null $supplierDefaultShippingCarrierId
 * @property string|null $supplierInternalNote
 * @property bool|null $supplierMergeItemsForOcrInvoiceUpload
 * @property float|null $supplierMinimumPurchaseOrderAmount
 * @property string|null $supplierNonStandardTaxId
 * @property string|null $supplierNumber
 * @property string|null $supplierNumberOld
 * @property bool|null $supplierOrderBlock
 * @property string|null $supplierPaymentMethodId
 * @property string|null $supplierShipmentMethodId
 * @property string|null $supplierTermOfPaymentId
 * @property array|null $tags
 * @property string|null $taxId
 * @property string|null $titleId
 * @property string|null $vatIdentificationNumber
 * @property string|null $xRechnungLeitwegId
 */
class Customer extends Model
{
    /**
     * Customer constructor.
     *
     * @codeCoverageIgnore
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (! in_array('partyType', array_keys($attributes))) {
            $this->partyType = 'ORGANIZATION';
        }
    }
}
