<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\Scopes\ContactScope;
use Geccomedia\Weclapp\SubModels\Address;
use Geccomedia\Weclapp\SubModels\CommissionSalesPartner;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\OnlineAccount;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\SubModels\PartyBankAccount;
use Geccomedia\Weclapp\SubModels\PartyEmailAddresses;
use Geccomedia\Weclapp\SubModels\PartyHabitualExporterLetterOfIntent;
use Geccomedia\Weclapp\SubModels\SalesStageHistory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $partyType
 * @property string|null $salutation
 * @property string|null $title
 * @property string|null $firstName
 * @property string|null $lastName
 * @property string|null $personCompany
 * @property string|null $personDepartment
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $mobilePhone1
 * @property string|null $fax
 * @property string|null $website
 * @property string|null $description
 * @property string|null $customerId
 * @property string|null $leadId
 * @property bool|null $primaryContact
 * @property list<Address>|null $addresses
 * @property list<OnlyId>|null $topics
 * @property list<PartyBankAccount>|null $bankAccounts
 * @property string|null $birthDate
 * @property string|null $commercialLanguageId
 * @property bool|null $commissionBlock
 * @property list<CommissionSalesPartner>|null $commissionSalesPartners
 * @property string|null $company
 * @property string|null $company2
 * @property string|null $companySizeId
 * @property bool|null $competitor
 * @property list<OnlyId>|null $contacts
 * @property string|null $convertedOnDate
 * @property string|null $currencyId
 * @property list<CustomAttribute>|null $customAttributes
 * @property bool|null $customer
 * @property bool|null $customerActive
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
 * @property string|null $customerNumber
 * @property string|null $customerNumberOld
 * @property string|null $customerPaymentMethodId
 * @property string|null $customerSalesChannel
 * @property string|null $customerSalesOrderPaymentType
 * @property float|null $customerSalesProbability
 * @property list<SalesStageHistory>|null $customerSalesStageHistory
 * @property string|null $customerSatisfaction
 * @property string|null $customerShipmentMethodId
 * @property string|null $customerSupplierNumber
 * @property string|null $customerTermOfPaymentId
 * @property bool|null $customerUseCustomsTariffNumber
 * @property string|null $deliveryAddressId
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
 * @property string|null $invoiceAddressId
 * @property bool|null $invoiceBlock
 * @property string|null $invoiceRecipientId
 * @property string|null $leadRatingId
 * @property string|null $leadSourceId
 * @property string|null $leadStatus
 * @property string|null $legalFormId
 * @property string|null $middleName
 * @property string|null $mobilePhone2
 * @property list<OnlineAccount>|null $onlineAccounts
 * @property bool|null $optInEmail
 * @property bool|null $optInLetter
 * @property bool|null $optInPhone
 * @property bool|null $optInSms
 * @property string|null $parentPartyId
 * @property list<PartyEmailAddresses>|null $partyEmailAddresses
 * @property list<PartyHabitualExporterLetterOfIntent>|null $partyHabitualExporterLettersOfIntent
 * @property string|null $personDepartmentId
 * @property string|null $personRoleId
 * @property string|null $phoneHome
 * @property string|null $primaryAddressId
 * @property string|null $primaryContactId
 * @property string|null $publicPageExpirationDate
 * @property string|null $publicPageUuid
 * @property string|null $purchaseEmailAddressesId
 * @property bool|null $purchaseViaPlafond
 * @property string|null $quotationEmailAddressesId
 * @property string|null $ratingId
 * @property string|null $referenceNumber
 * @property string|null $regionId
 * @property string|null $responsibleUserId
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
class Contact extends Model
{
    protected $table = 'party';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (! in_array('partyType', array_keys($attributes))) {
            $this->partyType = 'PERSON';
        }
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new ContactScope);
    }

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'addresses' => Address::class,
        'bankAccounts' => PartyBankAccount::class,
        'commissionSalesPartners' => CommissionSalesPartner::class,
        'contacts' => OnlyId::class,
        'customAttributes' => CustomAttribute::class,
        'customerSalesStageHistory' => SalesStageHistory::class,
        'onlineAccounts' => OnlineAccount::class,
        'partyEmailAddresses' => PartyEmailAddresses::class,
        'partyHabitualExporterLettersOfIntent' => PartyHabitualExporterLetterOfIntent::class,
        'topics' => OnlyId::class,
    ];

    /**
     * @return BelongsTo
     */
    public function commercialLanguage()
    {
        return $this->belongsTo(CommercialLanguage::class, 'commercialLanguageId');
    }

    /**
     * @return BelongsTo
     */
    public function companySize()
    {
        return $this->belongsTo(CompanySize::class, 'companySizeId');
    }

    /**
     * @return BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currencyId');
    }

    /**
     * @return BelongsTo
     */
    public function customerCategory()
    {
        return $this->belongsTo(CustomerCategory::class, 'customerCategoryId');
    }

    /**
     * @return BelongsTo
     */
    public function customerCurrentSalesStage()
    {
        return $this->belongsTo(SalesStage::class, 'customerCurrentSalesStageId');
    }

    /**
     * @return BelongsTo
     */
    public function customerDebtorAccount()
    {
        return $this->belongsTo(LedgerAccount::class, 'customerDebtorAccountId');
    }

    /**
     * @return BelongsTo
     */
    public function customerDefaultShippingCarrier()
    {
        return $this->belongsTo(ShippingCarrier::class, 'customerDefaultShippingCarrierId');
    }

    /**
     * @return BelongsTo
     */
    public function customerDefaultWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'customerDefaultWarehouseId');
    }

    /**
     * @return BelongsTo
     */
    public function customerLossReason()
    {
        return $this->belongsTo(CustomerLeadLossReason::class, 'customerLossReasonId');
    }

    /**
     * @return BelongsTo
     */
    public function customerNonStandardTax()
    {
        return $this->belongsTo(Tax::class, 'customerNonStandardTaxId');
    }

    /**
     * @return BelongsTo
     */
    public function customerPaymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'customerPaymentMethodId');
    }

    /**
     * @return BelongsTo
     */
    public function customerShipmentMethod()
    {
        return $this->belongsTo(ShipmentMethod::class, 'customerShipmentMethodId');
    }

    /**
     * @return BelongsTo
     */
    public function customerTermOfPayment()
    {
        return $this->belongsTo(TermOfPayment::class, 'customerTermOfPaymentId');
    }

    /**
     * @return BelongsTo
     */
    public function invoiceRecipient()
    {
        return $this->belongsTo(Party::class, 'invoiceRecipientId');
    }

    /**
     * @return BelongsTo
     */
    public function leadSource()
    {
        return $this->belongsTo(LeadSource::class, 'leadSourceId');
    }

    /**
     * @return BelongsTo
     */
    public function parentParty()
    {
        return $this->belongsTo(Party::class, 'parentPartyId');
    }

    /**
     * @return BelongsTo
     */
    public function primaryContact()
    {
        return $this->belongsTo(Party::class, 'primaryContactId');
    }

    /**
     * @return BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class, 'regionId');
    }

    /**
     * @return BelongsTo
     */
    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsibleUserId');
    }

    /**
     * @return BelongsTo
     */
    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sectorId');
    }

    /**
     * @return BelongsTo
     */
    public function supplierCreditorAccount()
    {
        return $this->belongsTo(LedgerAccount::class, 'supplierCreditorAccountId');
    }

    /**
     * @return BelongsTo
     */
    public function supplierDefaultShippingCarrier()
    {
        return $this->belongsTo(ShippingCarrier::class, 'supplierDefaultShippingCarrierId');
    }

    /**
     * @return BelongsTo
     */
    public function supplierNonStandardTax()
    {
        return $this->belongsTo(Tax::class, 'supplierNonStandardTaxId');
    }

    /**
     * @return BelongsTo
     */
    public function supplierPaymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'supplierPaymentMethodId');
    }

    /**
     * @return BelongsTo
     */
    public function supplierShipmentMethod()
    {
        return $this->belongsTo(ShipmentMethod::class, 'supplierShipmentMethodId');
    }

    /**
     * @return BelongsTo
     */
    public function supplierTermOfPayment()
    {
        return $this->belongsTo(TermOfPayment::class, 'supplierTermOfPaymentId');
    }

    /**
     * @return BelongsTo
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'taxId');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customerId');
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'leadId');
    }

    public function leadRating(): BelongsTo
    {
        return $this->belongsTo(LeadRating::class, 'leadRatingId');
    }

    public function legalForm(): BelongsTo
    {
        return $this->belongsTo(LegalForm::class, 'legalFormId');
    }

    public function personDepartment(): BelongsTo
    {
        return $this->belongsTo(PersonDepartment::class, 'personDepartmentId');
    }

    public function personRole(): BelongsTo
    {
        return $this->belongsTo(PersonRole::class, 'personRoleId');
    }

    public function title(): BelongsTo
    {
        return $this->belongsTo(Title::class, 'titleId');
    }
}
