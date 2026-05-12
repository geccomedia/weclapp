<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CommissionSalesPartner;
use Geccomedia\Weclapp\SubModels\ContractAdditionalAddress;
use Geccomedia\Weclapp\SubModels\ContractCostItem;
use Geccomedia\Weclapp\SubModels\ContractItem;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\EmailAddresses;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property list<ContractAdditionalAddress>|null $additionalAddresses
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
 * @property list<CommissionSalesPartner>|null $commissionSalesPartners
 * @property list<ContractCostItem>|null $contractCostItems
 * @property Carbon|null $contractDate
 * @property list<ContractItem>|null $contractItems
 * @property string|null $contractNumber
 * @property string|null $contractNumberAtParty
 * @property string|null $contractStatus
 * @property RecordAddress|null $correspondenceAddress
 * @property string|null $creatorId
 * @property list<CustomAttribute>|null $customAttributes
 * @property RecordAddress|null $deliveryAddress
 * @property EmailAddresses|null $deliveryEmailAddresses
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
 * @property RecordAddress|null $invoiceAddress
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
 * @property EmailAddresses|null $purchaseEmailAddresses
 * @property string|null $recordComment
 * @property string|null $recordCurrencyId
 * @property EmailAddresses|null $recordEmailAddresses
 * @property string|null $recordFreeText
 * @property string|null $recordOpening
 * @property Carbon|null $reminderDate
 * @property string|null $reminderSendType
 * @property string|null $reminderType
 * @property string|null $responsibleUserId
 * @property string|null $salesChannel
 * @property EmailAddresses|null $salesInvoiceEmailAddresses
 * @property EmailAddresses|null $salesOrderEmailAddresses
 * @property bool|null $sentToRecipient
 * @property Carbon|null $startDate
 * @property array|null $tags
 * @property string|null $technicalContactPersonId
 * @property bool|null $template
 * @property string|null $termOfPaymentId
 * @property string|null $terminationReasonId
 * @property string|null $ticketServiceLevelAgreementId
 * @property list<OnlyId>|null $types
 * @property bool|null $unlimited
 */
class Contract extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'additionalAddresses' => ContractAdditionalAddress::class,
        'commissionSalesPartners' => CommissionSalesPartner::class,
        'contractCostItems' => ContractCostItem::class,
        'contractItems' => ContractItem::class,
        'correspondenceAddress' => RecordAddress::class,
        'customAttributes' => CustomAttribute::class,
        'deliveryAddress' => RecordAddress::class,
        'deliveryEmailAddresses' => EmailAddresses::class,
        'invoiceAddress' => RecordAddress::class,
        'purchaseEmailAddresses' => EmailAddresses::class,
        'recordEmailAddresses' => EmailAddresses::class,
        'salesInvoiceEmailAddresses' => EmailAddresses::class,
        'salesOrderEmailAddresses' => EmailAddresses::class,
        'types' => OnlyId::class,
    ];

    /**
     * @return BelongsTo
     */
    public function authorizationUnit()
    {
        return $this->belongsTo(ContractAuthorizationUnit::class, 'authorizationUnitId');
    }

    /**
     * @return BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorId');
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
    public function nonStandardInputTax()
    {
        return $this->belongsTo(Tax::class, 'nonStandardInputTaxId');
    }

    /**
     * @return BelongsTo
     */
    public function nonStandardTax()
    {
        return $this->belongsTo(Tax::class, 'nonStandardTaxId');
    }

    /**
     * @return BelongsTo
     */
    public function party()
    {
        return $this->belongsTo(Party::class, 'partyId');
    }

    /**
     * @return BelongsTo
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'paymentMethodId');
    }

    /**
     * @return BelongsTo
     */
    public function recordCurrency()
    {
        return $this->belongsTo(Currency::class, 'recordCurrencyId');
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
    public function technicalContactPerson()
    {
        return $this->belongsTo(User::class, 'technicalContactPersonId');
    }

    /**
     * @return BelongsTo
     */
    public function termOfPayment()
    {
        return $this->belongsTo(TermOfPayment::class, 'termOfPaymentId');
    }

    /**
     * @return BelongsTo
     */
    public function ticketServiceLevelAgreement()
    {
        return $this->belongsTo(TicketServiceLevelAgreement::class, 'ticketServiceLevelAgreementId');
    }
}
