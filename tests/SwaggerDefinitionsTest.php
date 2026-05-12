<?php

namespace Geccomedia\Weclapp\Tests;

use Geccomedia\Weclapp\Models\AccountingTransaction;
use Geccomedia\Weclapp\Models\ArchivedEmail;
use Geccomedia\Weclapp\Models\Article;
use Geccomedia\Weclapp\Models\ArticleAccountingCode;
use Geccomedia\Weclapp\Models\ArticleCategory;
use Geccomedia\Weclapp\Models\ArticleCategoryClassification;
use Geccomedia\Weclapp\Models\ArticleItemGroup;
use Geccomedia\Weclapp\Models\ArticlePrice;
use Geccomedia\Weclapp\Models\ArticleRating;
use Geccomedia\Weclapp\Models\ArticleStatus;
use Geccomedia\Weclapp\Models\ArticleSupplySource;
use Geccomedia\Weclapp\Models\Attendance;
use Geccomedia\Weclapp\Models\BankAccount;
use Geccomedia\Weclapp\Models\BankTransaction;
use Geccomedia\Weclapp\Models\BatchNumber;
use Geccomedia\Weclapp\Models\BlanketPurchaseOrder;
use Geccomedia\Weclapp\Models\BlanketSalesOrder;
use Geccomedia\Weclapp\Models\Calendar;
use Geccomedia\Weclapp\Models\CalendarEvent;
use Geccomedia\Weclapp\Models\Campaign;
use Geccomedia\Weclapp\Models\CampaignParticipant;
use Geccomedia\Weclapp\Models\CashAccount;
use Geccomedia\Weclapp\Models\CashAccountSheet;
use Geccomedia\Weclapp\Models\CashAccountTransaction;
use Geccomedia\Weclapp\Models\Comment;
use Geccomedia\Weclapp\Models\CommercialLanguage;
use Geccomedia\Weclapp\Models\CompanySize;
use Geccomedia\Weclapp\Models\Contact;
use Geccomedia\Weclapp\Models\Contract;
use Geccomedia\Weclapp\Models\ContractAuthorizationUnit;
use Geccomedia\Weclapp\Models\ContractBillingGroup;
use Geccomedia\Weclapp\Models\ContractTerminationReason;
use Geccomedia\Weclapp\Models\ContractType;
use Geccomedia\Weclapp\Models\CostCenter;
use Geccomedia\Weclapp\Models\CostCenterGroup;
use Geccomedia\Weclapp\Models\CostType;
use Geccomedia\Weclapp\Models\CrmCallCategory;
use Geccomedia\Weclapp\Models\CrmEvent;
use Geccomedia\Weclapp\Models\CrmEventCategory;
use Geccomedia\Weclapp\Models\Currency;
use Geccomedia\Weclapp\Models\CustomAttributeDefinition;
use Geccomedia\Weclapp\Models\Customer;
use Geccomedia\Weclapp\Models\CustomerCategory;
use Geccomedia\Weclapp\Models\CustomerLeadLossReason;
use Geccomedia\Weclapp\Models\CustomerTopic;
use Geccomedia\Weclapp\Models\CustomsTariffNumber;
use Geccomedia\Weclapp\Models\Document;
use Geccomedia\Weclapp\Models\ExternalConnection;
use Geccomedia\Weclapp\Models\FinancialYear;
use Geccomedia\Weclapp\Models\FulfillmentProvider;
use Geccomedia\Weclapp\Models\IncomingGoods;
use Geccomedia\Weclapp\Models\InternalTransportReference;
use Geccomedia\Weclapp\Models\Inventory;
use Geccomedia\Weclapp\Models\InventoryGroup;
use Geccomedia\Weclapp\Models\InventoryItem;
use Geccomedia\Weclapp\Models\InventoryTransportReference;
use Geccomedia\Weclapp\Models\Lead;
use Geccomedia\Weclapp\Models\LeadRating;
use Geccomedia\Weclapp\Models\LeadSource;
use Geccomedia\Weclapp\Models\LedgerAccount;
use Geccomedia\Weclapp\Models\LegalForm;
use Geccomedia\Weclapp\Models\LoadingEquipmentIdentifier;
use Geccomedia\Weclapp\Models\MailTemplate;
use Geccomedia\Weclapp\Models\Manufacturer;
use Geccomedia\Weclapp\Models\Notification;
use Geccomedia\Weclapp\Models\NumberRange;
use Geccomedia\Weclapp\Models\NumberRangeValue;
use Geccomedia\Weclapp\Models\Opportunity;
use Geccomedia\Weclapp\Models\OpportunityTopic;
use Geccomedia\Weclapp\Models\OpportunityWinLossReason;
use Geccomedia\Weclapp\Models\Party;
use Geccomedia\Weclapp\Models\PartyRating;
use Geccomedia\Weclapp\Models\PaymentMethod;
use Geccomedia\Weclapp\Models\PaymentRun;
use Geccomedia\Weclapp\Models\PaymentRunItem;
use Geccomedia\Weclapp\Models\PerformanceRecord;
use Geccomedia\Weclapp\Models\PersonalAccountingCode;
use Geccomedia\Weclapp\Models\PersonDepartment;
use Geccomedia\Weclapp\Models\PersonRole;
use Geccomedia\Weclapp\Models\Pick;
use Geccomedia\Weclapp\Models\PickCheckReason;
use Geccomedia\Weclapp\Models\PlaceOfService;
use Geccomedia\Weclapp\Models\PriceCalculationParameter;
use Geccomedia\Weclapp\Models\ProductionOrder;
use Geccomedia\Weclapp\Models\ProductionWorkSchedule;
use Geccomedia\Weclapp\Models\ProductionWorkScheduleAssignment;
use Geccomedia\Weclapp\Models\ProjectOrderStatusPage;
use Geccomedia\Weclapp\Models\PropertyTranslation;
use Geccomedia\Weclapp\Models\PurchaseInvoice;
use Geccomedia\Weclapp\Models\PurchaseOpenItem;
use Geccomedia\Weclapp\Models\PurchaseOrder;
use Geccomedia\Weclapp\Models\PurchaseOrderRequest;
use Geccomedia\Weclapp\Models\PurchaseRequisition;
use Geccomedia\Weclapp\Models\Quotation;
use Geccomedia\Weclapp\Models\Rebate;
use Geccomedia\Weclapp\Models\RecordEmailingRule;
use Geccomedia\Weclapp\Models\Region;
use Geccomedia\Weclapp\Models\Reminder;
use Geccomedia\Weclapp\Models\RemotePrintJob;
use Geccomedia\Weclapp\Models\SalesChannel;
use Geccomedia\Weclapp\Models\SalesInvoice;
use Geccomedia\Weclapp\Models\SalesOpenItem;
use Geccomedia\Weclapp\Models\SalesOrder;
use Geccomedia\Weclapp\Models\SalesStage;
use Geccomedia\Weclapp\Models\SalesTeam;
use Geccomedia\Weclapp\Models\Sector;
use Geccomedia\Weclapp\Models\SepaDirectDebitMandate;
use Geccomedia\Weclapp\Models\SerialNumber;
use Geccomedia\Weclapp\Models\ServiceQuota;
use Geccomedia\Weclapp\Models\Shelf;
use Geccomedia\Weclapp\Models\Shipment;
use Geccomedia\Weclapp\Models\ShipmentMethod;
use Geccomedia\Weclapp\Models\ShipmentReturnAssessment;
use Geccomedia\Weclapp\Models\ShipmentReturnError;
use Geccomedia\Weclapp\Models\ShipmentReturnReason;
use Geccomedia\Weclapp\Models\ShipmentReturnRectification;
use Geccomedia\Weclapp\Models\ShippingCarrier;
use Geccomedia\Weclapp\Models\StorageLocation;
use Geccomedia\Weclapp\Models\StoragePlace;
use Geccomedia\Weclapp\Models\StoragePlaceBlockingReason;
use Geccomedia\Weclapp\Models\StoragePlaceSize;
use Geccomedia\Weclapp\Models\Supplier;
use Geccomedia\Weclapp\Models\Tag;
use Geccomedia\Weclapp\Models\Task;
use Geccomedia\Weclapp\Models\TaskList;
use Geccomedia\Weclapp\Models\TaskTemplate;
use Geccomedia\Weclapp\Models\Tax;
use Geccomedia\Weclapp\Models\TaxDeterminationRule;
use Geccomedia\Weclapp\Models\TermOfPayment;
use Geccomedia\Weclapp\Models\Ticket;
use Geccomedia\Weclapp\Models\TicketAssignmentRule;
use Geccomedia\Weclapp\Models\TicketCategory;
use Geccomedia\Weclapp\Models\TicketChannel;
use Geccomedia\Weclapp\Models\TicketFaq;
use Geccomedia\Weclapp\Models\TicketPoolingGroup;
use Geccomedia\Weclapp\Models\TicketServiceLevelAgreement;
use Geccomedia\Weclapp\Models\TicketStatus;
use Geccomedia\Weclapp\Models\TicketType;
use Geccomedia\Weclapp\Models\TimeRecord;
use Geccomedia\Weclapp\Models\Title;
use Geccomedia\Weclapp\Models\Translation;
use Geccomedia\Weclapp\Models\TransportationOrder;
use Geccomedia\Weclapp\Models\Unit;
use Geccomedia\Weclapp\Models\User;
use Geccomedia\Weclapp\Models\UserRole;
use Geccomedia\Weclapp\Models\VariantArticle;
use Geccomedia\Weclapp\Models\VariantArticleAttribute;
use Geccomedia\Weclapp\Models\VariantArticleVariant;
use Geccomedia\Weclapp\Models\Warehouse;
use Geccomedia\Weclapp\Models\WarehouseStock;
use Geccomedia\Weclapp\Models\WarehouseStockMovement;
use Geccomedia\Weclapp\Models\Webhook;
use Geccomedia\Weclapp\Models\WeclappOs;
use Geccomedia\Weclapp\SubModels\AcceptQuotationItem;
use Geccomedia\Weclapp\SubModels\AccountingTransactionDetail;
use Geccomedia\Weclapp\SubModels\Address;
use Geccomedia\Weclapp\SubModels\AggregatePackagingUnit;
use Geccomedia\Weclapp\SubModels\AggregateStock;
use Geccomedia\Weclapp\SubModels\Amount;
use Geccomedia\Weclapp\SubModels\ApiProblem;
use Geccomedia\Weclapp\SubModels\ArticleAlternativeQuantity;
use Geccomedia\Weclapp\SubModels\ArticleCalculationPrice;
use Geccomedia\Weclapp\SubModels\ArticleImage;
use Geccomedia\Weclapp\SubModels\ArticleItemGroupItem;
use Geccomedia\Weclapp\SubModels\ArticlePriceWithoutArticleReference;
use Geccomedia\Weclapp\SubModels\ArticlePriceWithoutSalesChannel;
use Geccomedia\Weclapp\SubModels\BatchBooking;
use Geccomedia\Weclapp\SubModels\BatchBookingRecord;
use Geccomedia\Weclapp\SubModels\BatchSerialNumber;
use Geccomedia\Weclapp\SubModels\BillOfMaterial;
use Geccomedia\Weclapp\SubModels\BlanketPurchaseOrderStatusHistory;
use Geccomedia\Weclapp\SubModels\BlanketSalesOrderItem;
use Geccomedia\Weclapp\SubModels\BlanketSalesOrderStatusHistory;
use Geccomedia\Weclapp\SubModels\CalendarEventAttendee;
use Geccomedia\Weclapp\SubModels\CalendarSharingPermissions;
use Geccomedia\Weclapp\SubModels\CashAccountCashCountItem;
use Geccomedia\Weclapp\SubModels\CommissionSalesPartner;
use Geccomedia\Weclapp\SubModels\ConditionsForEntityType;
use Geccomedia\Weclapp\SubModels\ContractAdditionalAddress;
use Geccomedia\Weclapp\SubModels\ContractCostItem;
use Geccomedia\Weclapp\SubModels\ContractItem;
use Geccomedia\Weclapp\SubModels\CostCenterWithDistributionPercentage;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\CustomAttributeDefinitionConditions;
use Geccomedia\Weclapp\SubModels\CustomAttributeDefinitionListValue;
use Geccomedia\Weclapp\SubModels\CustomAttributeDefinitionOrder;
use Geccomedia\Weclapp\SubModels\CustomAttributeDefinitionPermission;
use Geccomedia\Weclapp\SubModels\CustomAttributeDefinitionPropertyCondition;
use Geccomedia\Weclapp\SubModels\CustomAttributeDefinitionTranslation;
use Geccomedia\Weclapp\SubModels\CustomerSpecificArticleAttributes;
use Geccomedia\Weclapp\SubModels\DemoTestSystemInfo;
use Geccomedia\Weclapp\SubModels\DocumentVersion;
use Geccomedia\Weclapp\SubModels\DropshippingDeliveryNoteFormTextBlockData;
use Geccomedia\Weclapp\SubModels\DropshippingShipmentParameters;
use Geccomedia\Weclapp\SubModels\Duration;
use Geccomedia\Weclapp\SubModels\EcommerceOrder;
use Geccomedia\Weclapp\SubModels\EmailAddresses;
use Geccomedia\Weclapp\SubModels\EntityReference;
use Geccomedia\Weclapp\SubModels\ExistingReservation;
use Geccomedia\Weclapp\SubModels\FastProductionBookingResult;
use Geccomedia\Weclapp\SubModels\IncomingBooking;
use Geccomedia\Weclapp\SubModels\IncomingGoodsItem;
use Geccomedia\Weclapp\SubModels\InventorySerialNumber;
use Geccomedia\Weclapp\SubModels\InventoryStatusHistory;
use Geccomedia\Weclapp\SubModels\ItemAvailability;
use Geccomedia\Weclapp\SubModels\ItemPick;
use Geccomedia\Weclapp\SubModels\JobProgress;
use Geccomedia\Weclapp\SubModels\JobResult;
use Geccomedia\Weclapp\SubModels\License;
use Geccomedia\Weclapp\SubModels\MinimalStoragePlace;
use Geccomedia\Weclapp\SubModels\NestedStoragePlace;
use Geccomedia\Weclapp\SubModels\OnlineAccount;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\SubModels\PackagingUnit;
use Geccomedia\Weclapp\SubModels\Parcel;
use Geccomedia\Weclapp\SubModels\PartyBankAccount;
use Geccomedia\Weclapp\SubModels\PartyEmailAddresses;
use Geccomedia\Weclapp\SubModels\PartyHabitualExporterLetterOfIntent;
use Geccomedia\Weclapp\SubModels\PaymentApplication;
use Geccomedia\Weclapp\SubModels\PerformanceRecordItem;
use Geccomedia\Weclapp\SubModels\PerformanceRecordStatusHistory;
use Geccomedia\Weclapp\SubModels\Period;
use Geccomedia\Weclapp\SubModels\PriceData;
use Geccomedia\Weclapp\SubModels\PriceDataReductionAdditionItem;
use Geccomedia\Weclapp\SubModels\Problem;
use Geccomedia\Weclapp\SubModels\ProcessPurchaseOrderItem;
use Geccomedia\Weclapp\SubModels\ProductionOrderItem;
use Geccomedia\Weclapp\SubModels\ProductionOrderStatusHistory;
use Geccomedia\Weclapp\SubModels\ProductionOrderWorkItem;
use Geccomedia\Weclapp\SubModels\ProductionWorkScheduleItem;
use Geccomedia\Weclapp\SubModels\ProjectMembers;
use Geccomedia\Weclapp\SubModels\PropertyTranslationValue;
use Geccomedia\Weclapp\SubModels\PurchaseInvoiceItem;
use Geccomedia\Weclapp\SubModels\PurchaseInvoiceItemRelationship;
use Geccomedia\Weclapp\SubModels\PurchaseInvoiceShippingCostItem;
use Geccomedia\Weclapp\SubModels\PurchaseInvoiceStatusHistory;
use Geccomedia\Weclapp\SubModels\PurchaseOrderItem;
use Geccomedia\Weclapp\SubModels\PurchaseOrderRequestItem;
use Geccomedia\Weclapp\SubModels\PurchaseOrderRequestItemScaleValue;
use Geccomedia\Weclapp\SubModels\PurchaseOrderRequestOffer;
use Geccomedia\Weclapp\SubModels\PurchaseOrderRequestOfferItem;
use Geccomedia\Weclapp\SubModels\PurchaseOrderRequestOfferItemInformation;
use Geccomedia\Weclapp\SubModels\PurchaseOrderRequestOfferItemScaleValue;
use Geccomedia\Weclapp\SubModels\PurchaseOrderRequestStatusHistory;
use Geccomedia\Weclapp\SubModels\PurchaseOrderShippingCostItem;
use Geccomedia\Weclapp\SubModels\PurchaseOrderStatusHistory;
use Geccomedia\Weclapp\SubModels\PurchaseRequisitionStatusHistory;
use Geccomedia\Weclapp\SubModels\QuantityConversion;
use Geccomedia\Weclapp\SubModels\QuotationItem;
use Geccomedia\Weclapp\SubModels\QuotationItemRelationship;
use Geccomedia\Weclapp\SubModels\QuotationItemScaleValue;
use Geccomedia\Weclapp\SubModels\QuotationShippingCostItem;
use Geccomedia\Weclapp\SubModels\QuotationStatusHistory;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Geccomedia\Weclapp\SubModels\RecurringEvent;
use Geccomedia\Weclapp\SubModels\ReductionAddition;
use Geccomedia\Weclapp\SubModels\ReductionAdditionItem;
use Geccomedia\Weclapp\SubModels\Releases;
use Geccomedia\Weclapp\SubModels\ReminderRecurringEvent;
use Geccomedia\Weclapp\SubModels\SalesBillOfMaterialArticleItem;
use Geccomedia\Weclapp\SubModels\SalesChannelUsage;
use Geccomedia\Weclapp\SubModels\SalesInvoiceItem;
use Geccomedia\Weclapp\SubModels\SalesInvoiceItemRelationship;
use Geccomedia\Weclapp\SubModels\SalesInvoiceShippingCostItem;
use Geccomedia\Weclapp\SubModels\SalesInvoiceStatusHistory;
use Geccomedia\Weclapp\SubModels\SalesOrderItem;
use Geccomedia\Weclapp\SubModels\SalesOrderPayment;
use Geccomedia\Weclapp\SubModels\SalesOrderShippingCostItem;
use Geccomedia\Weclapp\SubModels\SalesOrderStatusHistory;
use Geccomedia\Weclapp\SubModels\SalesStageHistory;
use Geccomedia\Weclapp\SubModels\ServiceQuotaRelationship;
use Geccomedia\Weclapp\SubModels\ServiceQuotaStatusHistory;
use Geccomedia\Weclapp\SubModels\ShipmentItem;
use Geccomedia\Weclapp\SubModels\ShipmentStatus;
use Geccomedia\Weclapp\SubModels\StoragePlaceTypeSettings;
use Geccomedia\Weclapp\SubModels\SuccessResponse;
use Geccomedia\Weclapp\SubModels\SupplySource;
use Geccomedia\Weclapp\SubModels\TaskAssignee;
use Geccomedia\Weclapp\SubModels\TaskBillingData;
use Geccomedia\Weclapp\SubModels\TaskMailAccount;
use Geccomedia\Weclapp\SubModels\TaskTemplateAssignee;
use Geccomedia\Weclapp\SubModels\TermOfPaymentCondition;
use Geccomedia\Weclapp\SubModels\TicketPoolingGroupMember;
use Geccomedia\Weclapp\SubModels\TicketServiceLevelAgreementTarget;
use Geccomedia\Weclapp\SubModels\TranslationValue;
use Geccomedia\Weclapp\SubModels\TransportationOrderStatusHistory;
use Geccomedia\Weclapp\SubModels\TransportPick;
use Geccomedia\Weclapp\SubModels\UserMfaDevice;
use Geccomedia\Weclapp\SubModels\ValidationError;
use Geccomedia\Weclapp\SubModels\ValidationErrorCodeInfo;
use Geccomedia\Weclapp\SubModels\ValidationErrorCodes;
use Geccomedia\Weclapp\SubModels\VariantArticleAttributeOption;
use Geccomedia\Weclapp\SubModels\VariantArticleVariantWithoutReference;
use Geccomedia\Weclapp\SubModels\WarehouseQuantity;
use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Verifies that every property declared in a swagger definition at
 * https://www.weclapp.com/api/swagger.json is also declared as a
 * "@property" annotation on the corresponding model class.
 */
class SwaggerDefinitionsTest extends TestCase
{
    /**
     * Maps swagger definition name -> model FQCN.
     *
     * Notes:
     * - customer / contact / lead / supplier have no dedicated swagger definition;
     *   they all map to the "party" definition.
     * - Simple lookup-table endpoints (companySize, customerCategory, …) all map
     *   to "customValue" in swagger; each such model is tested individually below.
     */
    private const DEFINITION_TO_MODELS = [
        'archivedEmail' => [ArchivedEmail::class],
        'article' => [Article::class],
        'articleCategory' => [ArticleCategory::class],
        'articlePrice' => [ArticlePrice::class],
        'articleSupplySource' => [ArticleSupplySource::class],
        'batchNumber' => [BatchNumber::class],
        'campaign' => [Campaign::class],
        'campaignParticipant' => [CampaignParticipant::class],
        'comment' => [Comment::class],
        'commercialLanguage' => [CommercialLanguage::class],
        'currency' => [Currency::class],
        'customAttributeDefinition' => [CustomAttributeDefinition::class],
        'document' => [Document::class],
        'fulfillmentProvider' => [FulfillmentProvider::class],
        'incomingGoods' => [IncomingGoods::class],
        'manufacturer' => [Manufacturer::class],
        'opportunity' => [Opportunity::class],
        'paymentMethod' => [PaymentMethod::class],
        'productionOrder' => [ProductionOrder::class],
        'purchaseOrder' => [PurchaseOrder::class],
        'quotation' => [Quotation::class],
        'salesChannel' => [SalesChannel::class],
        'salesInvoice' => [SalesInvoice::class],
        'salesOrder' => [SalesOrder::class],
        'salesStage' => [SalesStage::class],
        'serialNumber' => [SerialNumber::class],
        'shipment' => [Shipment::class],
        'shipmentMethod' => [ShipmentMethod::class],
        'tax' => [Tax::class],
        'termOfPayment' => [TermOfPayment::class],
        'unit' => [Unit::class],
        'user' => [User::class],
        'variantArticle' => [VariantArticle::class],
        'variantArticleAttribute' => [VariantArticleAttribute::class],
        'variantArticleVariant' => [VariantArticleVariant::class],
        'warehouse' => [Warehouse::class],
        'warehouseStock' => [WarehouseStock::class],
        'warehouseStockMovement' => [WarehouseStockMovement::class],
        'accountingTransaction' => [AccountingTransaction::class],
        'articleItemGroup' => [ArticleItemGroup::class],
        'attendance' => [Attendance::class],
        'bankAccount' => [BankAccount::class],
        'bankTransaction' => [BankTransaction::class],
        'blanketPurchaseOrder' => [BlanketPurchaseOrder::class],
        'blanketSalesOrder' => [BlanketSalesOrder::class],
        'calendar' => [Calendar::class],
        'calendarEvent' => [CalendarEvent::class],
        'cashAccount' => [CashAccount::class],
        'cashAccountSheet' => [CashAccountSheet::class],
        'cashAccountTransaction' => [CashAccountTransaction::class],
        'contract' => [Contract::class],
        'contractAuthorizationUnit' => [ContractAuthorizationUnit::class],
        'contractType' => [ContractType::class],
        'costCenter' => [CostCenter::class],
        'costType' => [CostType::class],
        'crmEvent' => [CrmEvent::class],
        'externalConnection' => [ExternalConnection::class],
        'financialYear' => [FinancialYear::class],
        'internalTransportReference' => [InternalTransportReference::class],
        'inventory' => [Inventory::class],
        'inventoryGroup' => [InventoryGroup::class],
        'inventoryItem' => [InventoryItem::class],
        'inventoryTransportReference' => [InventoryTransportReference::class],
        'ledgerAccount' => [LedgerAccount::class],
        'loadingEquipmentIdentifier' => [LoadingEquipmentIdentifier::class],
        'mailTemplate' => [MailTemplate::class],
        'notification' => [Notification::class],
        'numberRange' => [NumberRange::class],
        'numberRangeValue' => [NumberRangeValue::class],
        'paymentRun' => [PaymentRun::class],
        'paymentRunItem' => [PaymentRunItem::class],
        'performanceRecord' => [PerformanceRecord::class],
        'pick' => [Pick::class],
        'priceCalculationParameter' => [PriceCalculationParameter::class],
        'propertyTranslation' => [PropertyTranslation::class],
        'productionWorkSchedule' => [ProductionWorkSchedule::class],
        'productionWorkScheduleAssignment' => [ProductionWorkScheduleAssignment::class],
        'projectOrderStatusPage' => [ProjectOrderStatusPage::class],
        'purchaseInvoice' => [PurchaseInvoice::class],
        'purchaseOpenItem' => [PurchaseOpenItem::class],
        'purchaseOrderRequest' => [PurchaseOrderRequest::class],
        'purchaseRequisition' => [PurchaseRequisition::class],
        'rebate' => [Rebate::class],
        'recordEmailingRule' => [RecordEmailingRule::class],
        'region' => [Region::class],
        'reminder' => [Reminder::class],
        'remotePrintJob' => [RemotePrintJob::class],
        'salesOpenItem' => [SalesOpenItem::class],
        'salesTeam' => [SalesTeam::class],
        'sepaDirectDebitMandate' => [SepaDirectDebitMandate::class],
        'serviceQuota' => [ServiceQuota::class],
        'shelf' => [Shelf::class],
        // Four endpoints share the shipmentReturnDescription definition.
        'shipmentReturnDescription' => [
            ShipmentReturnAssessment::class,
            ShipmentReturnError::class,
            ShipmentReturnReason::class,
            ShipmentReturnRectification::class,
        ],
        'shippingCarrier' => [ShippingCarrier::class],
        'storageLocation' => [StorageLocation::class],
        'storagePlace' => [StoragePlace::class],
        'storagePlaceSize' => [StoragePlaceSize::class],
        'tag' => [Tag::class],
        'task' => [Task::class],
        'taskList' => [TaskList::class],
        'taskTemplate' => [TaskTemplate::class],
        'taxDeterminationRule' => [TaxDeterminationRule::class],
        'ticket' => [Ticket::class],
        'ticketAssignmentRule' => [TicketAssignmentRule::class],
        'ticketCategory' => [TicketCategory::class],
        'ticketFaq' => [TicketFaq::class],
        'ticketPoolingGroup' => [TicketPoolingGroup::class],
        'ticketServiceLevelAgreement' => [TicketServiceLevelAgreement::class],
        'ticketStatus' => [TicketStatus::class],
        'ticketType' => [TicketType::class],
        'timeRecord' => [TimeRecord::class],
        'translation' => [Translation::class],
        'transportationOrder' => [TransportationOrder::class],
        'userRole' => [UserRole::class],
        'webhook' => [Webhook::class],
        'weclappOs' => [WeclappOs::class],
        // Several distinct model classes share the single "party" swagger definition.
        'party' => [
            Party::class,
            Customer::class,
            Contact::class,
            Lead::class,
            Supplier::class,
        ],
        // Simple lookup-table models all share the "customValue" swagger definition.
        'customValue' => [
            ArticleAccountingCode::class,
            ArticleCategoryClassification::class,
            ArticleRating::class,
            ArticleStatus::class,
            CompanySize::class,
            ContractBillingGroup::class,
            ContractTerminationReason::class,
            CostCenterGroup::class,
            CrmCallCategory::class,
            CrmEventCategory::class,
            CustomerCategory::class,
            CustomerLeadLossReason::class,
            CustomerTopic::class,
            CustomsTariffNumber::class,
            LeadRating::class,
            LeadSource::class,
            LegalForm::class,
            OpportunityTopic::class,
            OpportunityWinLossReason::class,
            PartyRating::class,
            PersonDepartment::class,
            PersonRole::class,
            PersonalAccountingCode::class,
            PickCheckReason::class,
            PlaceOfService::class,
            Sector::class,
            StoragePlaceBlockingReason::class,
            TicketChannel::class,
            Title::class,
        ],
    ];

    /**
     * Maps swagger sub-definition name (not reachable via paths) -> sub-model FQCN.
     *
     * These are embedded objects/arrays within top-level model responses.
     *
     * @var array<string, string>
     */
    private const SUB_DEFINITION_TO_CLASS = [
        'acceptQuotationItem' => AcceptQuotationItem::class,
        'accountingTransactionDetail' => AccountingTransactionDetail::class,
        'address' => Address::class,
        'aggregatePackagingUnit' => AggregatePackagingUnit::class,
        'aggregateStock' => AggregateStock::class,
        'apiProblem' => ApiProblem::class,
        'articleAlternativeQuantity' => ArticleAlternativeQuantity::class,
        'articleCalculationPrice' => ArticleCalculationPrice::class,
        'articleImage' => ArticleImage::class,
        'articleItemGroupItem' => ArticleItemGroupItem::class,
        'articlePriceWithoutArticleReference' => ArticlePriceWithoutArticleReference::class,
        'articlePriceWithoutSalesChannel' => ArticlePriceWithoutSalesChannel::class,
        'batchBookingRecord' => BatchBookingRecord::class,
        'batchSerialNumber' => BatchSerialNumber::class,
        'billOfMaterial' => BillOfMaterial::class,
        'blanketPurchaseOrderStatusHistory' => BlanketPurchaseOrderStatusHistory::class,
        'blanketSalesOrderItem' => BlanketSalesOrderItem::class,
        'blanketSalesOrderStatusHistory' => BlanketSalesOrderStatusHistory::class,
        'calendarEventAttendee' => CalendarEventAttendee::class,
        'calendarSharingPermissions' => CalendarSharingPermissions::class,
        'cashAccountCashCountItem' => CashAccountCashCountItem::class,
        'commissionSalesPartner' => CommissionSalesPartner::class,
        'conditionsForEntityType' => ConditionsForEntityType::class,
        'contractAdditionalAddress' => ContractAdditionalAddress::class,
        'contractCostItem' => ContractCostItem::class,
        'contractItem' => ContractItem::class,
        'costCenterWithDistributionPercentage' => CostCenterWithDistributionPercentage::class,
        'customAttributeDefinitionConditions' => CustomAttributeDefinitionConditions::class,
        'customAttributeDefinitionListValue' => CustomAttributeDefinitionListValue::class,
        'customAttributeDefinitionPermission' => CustomAttributeDefinitionPermission::class,
        'customAttributeDefinitionPropertyCondition' => CustomAttributeDefinitionPropertyCondition::class,
        'customAttributeDefinitionTranslation' => CustomAttributeDefinitionTranslation::class,
        'customerSpecificArticleAttributes' => CustomerSpecificArticleAttributes::class,
        'documentVersion' => DocumentVersion::class,
        'dropshippingDeliveryNoteFormTextBlockData' => DropshippingDeliveryNoteFormTextBlockData::class,
        'ecommerceOrder' => EcommerceOrder::class,
        'emailAddresses' => EmailAddresses::class,
        'entityReference' => EntityReference::class,
        'incomingGoodsItem' => IncomingGoodsItem::class,
        'inventorySerialNumber' => InventorySerialNumber::class,
        'inventoryStatusHistory' => InventoryStatusHistory::class,
        'itemPick' => ItemPick::class,
        'jobProgress' => JobProgress::class,
        'minimalStoragePlace' => MinimalStoragePlace::class,
        'nestedStoragePlace' => NestedStoragePlace::class,
        'onlineAccount' => OnlineAccount::class,
        'packagingUnit' => PackagingUnit::class,
        'parcel' => Parcel::class,
        'partyBankAccount' => PartyBankAccount::class,
        'partyEmailAddresses' => PartyEmailAddresses::class,
        'partyHabitualExporterLetterOfIntent' => PartyHabitualExporterLetterOfIntent::class,
        'paymentApplication' => PaymentApplication::class,
        'performanceRecordItem' => PerformanceRecordItem::class,
        'performanceRecordStatusHistory' => PerformanceRecordStatusHistory::class,
        'period' => Period::class,
        'priceDataReductionAdditionItem' => PriceDataReductionAdditionItem::class,
        'productionOrderItem' => ProductionOrderItem::class,
        'productionOrderStatusHistory' => ProductionOrderStatusHistory::class,
        'productionOrderWorkItem' => ProductionOrderWorkItem::class,
        'productionWorkScheduleItem' => ProductionWorkScheduleItem::class,
        'projectMembers' => ProjectMembers::class,
        'propertyTranslationValue' => PropertyTranslationValue::class,
        'purchaseInvoiceItem' => PurchaseInvoiceItem::class,
        'purchaseInvoiceItemRelationship' => PurchaseInvoiceItemRelationship::class,
        'purchaseInvoiceShippingCostItem' => PurchaseInvoiceShippingCostItem::class,
        'purchaseInvoiceStatusHistory' => PurchaseInvoiceStatusHistory::class,
        'purchaseOrderItem' => PurchaseOrderItem::class,
        'purchaseOrderRequestItem' => PurchaseOrderRequestItem::class,
        'purchaseOrderRequestItemScaleValue' => PurchaseOrderRequestItemScaleValue::class,
        'purchaseOrderRequestOffer' => PurchaseOrderRequestOffer::class,
        'purchaseOrderRequestOfferItem' => PurchaseOrderRequestOfferItem::class,
        'purchaseOrderRequestOfferItemScaleValue' => PurchaseOrderRequestOfferItemScaleValue::class,
        'purchaseOrderRequestStatusHistory' => PurchaseOrderRequestStatusHistory::class,
        'purchaseOrderShippingCostItem' => PurchaseOrderShippingCostItem::class,
        'purchaseOrderStatusHistory' => PurchaseOrderStatusHistory::class,
        'purchaseRequisitionStatusHistory' => PurchaseRequisitionStatusHistory::class,
        'quantityConversion' => QuantityConversion::class,
        'quotationItem' => QuotationItem::class,
        'quotationItemRelationship' => QuotationItemRelationship::class,
        'quotationItemScaleValue' => QuotationItemScaleValue::class,
        'quotationShippingCostItem' => QuotationShippingCostItem::class,
        'quotationStatusHistory' => QuotationStatusHistory::class,
        'recordAddress' => RecordAddress::class,
        'recurringEvent' => RecurringEvent::class,
        'reductionAddition' => ReductionAddition::class,
        'reductionAdditionItem' => ReductionAdditionItem::class,
        'releases' => Releases::class,
        'reminderRecurringEvent' => ReminderRecurringEvent::class,
        'salesBillOfMaterialArticleItem' => SalesBillOfMaterialArticleItem::class,
        'salesInvoiceItem' => SalesInvoiceItem::class,
        'salesInvoiceItemRelationship' => SalesInvoiceItemRelationship::class,
        'salesInvoiceShippingCostItem' => SalesInvoiceShippingCostItem::class,
        'salesInvoiceStatusHistory' => SalesInvoiceStatusHistory::class,
        'salesOrderItem' => SalesOrderItem::class,
        'salesOrderPayment' => SalesOrderPayment::class,
        'salesOrderShippingCostItem' => SalesOrderShippingCostItem::class,
        'salesOrderStatusHistory' => SalesOrderStatusHistory::class,
        'salesStageHistory' => SalesStageHistory::class,
        'serviceQuotaRelationship' => ServiceQuotaRelationship::class,
        'serviceQuotaStatusHistory' => ServiceQuotaStatusHistory::class,
        'shipmentItem' => ShipmentItem::class,
        'shipmentStatus' => ShipmentStatus::class,
        'storagePlaceTypeSettings' => StoragePlaceTypeSettings::class,
        'supplySource' => SupplySource::class,
        'taskAssignee' => TaskAssignee::class,
        'taskMailAccount' => TaskMailAccount::class,
        'taskTemplateAssignee' => TaskTemplateAssignee::class,
        'termOfPaymentCondition' => TermOfPaymentCondition::class,
        'ticketPoolingGroupMember' => TicketPoolingGroupMember::class,
        'ticketServiceLevelAgreementTarget' => TicketServiceLevelAgreementTarget::class,
        'translationValue' => TranslationValue::class,
        'transportPick' => TransportPick::class,
        'transportationOrderStatusHistory' => TransportationOrderStatusHistory::class,
        'validationError' => ValidationError::class,
        'validationErrorCodeInfo' => ValidationErrorCodeInfo::class,
        'variantArticleAttributeOption' => VariantArticleAttributeOption::class,
        'variantArticleVariantWithoutReference' => VariantArticleVariantWithoutReference::class,
        'amount' => Amount::class,
        'batchBooking' => BatchBooking::class,
        'customAttribute' => CustomAttribute::class,
        'customAttributeDefinitionOrder' => CustomAttributeDefinitionOrder::class,
        'demoTestSystemInfo' => DemoTestSystemInfo::class,
        'dropshippingShipmentParameters' => DropshippingShipmentParameters::class,
        'duration' => Duration::class,
        'existingReservation' => ExistingReservation::class,
        'fastProductionBookingResult' => FastProductionBookingResult::class,
        'incomingBooking' => IncomingBooking::class,
        'itemAvailability' => ItemAvailability::class,
        'jobResult' => JobResult::class,
        'license' => License::class,
        'onlyId' => OnlyId::class,
        'priceData' => PriceData::class,
        'problem' => Problem::class,
        'processPurchaseOrderItem' => ProcessPurchaseOrderItem::class,
        'purchaseOrderRequestOfferItemInformation' => PurchaseOrderRequestOfferItemInformation::class,
        'salesChannelUsage' => SalesChannelUsage::class,
        'successResponse' => SuccessResponse::class,
        'taskBillingData' => TaskBillingData::class,
        'userMfaDevice' => UserMfaDevice::class,
        'validationErrorCodes' => ValidationErrorCodes::class,
        'warehouseQuantity' => WarehouseQuantity::class,
    ];

    /** @var array<string, list<string>>|null Cached definitions map: definitionName -> propertyNames */
    private static ?array $definitions = null;

    /** @var array<string, bool>|null Cached set of definition names referenced directly in swagger paths */
    private static ?array $pathRefs = null;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Fetches https://www.weclapp.com/api/swagger.json once per test run and
     * returns a map of  definitionName -> list<propertyName>.
     *
     * @return array<string, list<string>>
     */
    private static function definitions(): array
    {
        if (self::$definitions !== null) {
            return self::$definitions;
        }

        $client = new Client(['timeout' => 30]);
        $response = $client->get('https://www.weclapp.com/api/swagger.json');
        $swagger = json_decode((string) $response->getBody(), true, flags: JSON_THROW_ON_ERROR);

        self::$definitions = [];
        foreach ($swagger['definitions'] as $name => $definition) {
            self::$definitions[$name] = array_keys($definition['properties'] ?? []);
        }

        // Also cache path refs from the same document to avoid a second HTTP request.
        self::$pathRefs = [];
        preg_match_all('/#\/definitions\/(\w+)/', json_encode($swagger['paths']), $m);
        foreach ($m[1] as $ref) {
            self::$pathRefs[$ref] = true;
        }

        return self::$definitions;
    }

    /**
     * Returns the set of definition names referenced directly in swagger paths.
     * Populated as a side-effect of calling definitions().
     *
     * @return array<string, bool>
     */
    private static function pathRefs(): array
    {
        if (self::$pathRefs === null) {
            self::definitions();
        }

        return self::$pathRefs ?? [];
    }

    /**
     * Returns all "@property" names declared in the docblock of the given class
     * and every class in its inheritance chain.
     *
     * @return list<string>
     */
    private static function modelProperties(string $fqcn): array
    {
        $props = [];
        $rc = new ReflectionClass($fqcn);

        do {
            $doc = $rc->getDocComment();
            if ($doc !== false) {
                preg_match_all('/@property[^$]*\$(\w+)/', $doc, $matches);
                array_push($props, ...$matches[1]);
            }
        } while ($rc = $rc->getParentClass());

        return array_values(array_unique($props));
    }

    // -------------------------------------------------------------------------
    // Data provider
    // -------------------------------------------------------------------------

    /**
     * Yields one [definitionName, modelFqcn] row per (definition × model) pair.
     *
     * @return array<string, array{string, string}>
     */
    public static function definitionModelPairs(): array
    {
        $cases = [];

        foreach (self::DEFINITION_TO_MODELS as $definition => $models) {
            foreach ($models as $fqcn) {
                $shortName = (new ReflectionClass($fqcn))->getShortName();
                $key = count($models) > 1 ? "{$definition}:{$shortName}" : $definition;
                $cases[$key] = [$definition, $fqcn];
            }
        }

        return $cases;
    }

    /**
     * Yields one [definitionName, subModelFqcn] row per sub-definition entry.
     *
     * @return array<string, array{string, string}>
     */
    public static function subDefinitionClassPairs(): array
    {
        $cases = [];

        foreach (self::SUB_DEFINITION_TO_CLASS as $definition => $fqcn) {
            $cases[$definition] = [$definition, $fqcn];
        }

        return $cases;
    }

    // -------------------------------------------------------------------------
    // Tests
    // -------------------------------------------------------------------------

    /**
     * Every definition in the swagger spec that matches a model's $table name
     * must be listed in DEFINITION_TO_MODELS so it actually gets tested.
     */
    public function test_all_matching_swagger_definitions_are_covered(): void
    {
        $definitions = self::definitions();

        // Build a table-name -> FQCN map from the actual model files on disk.
        $modelTables = [];
        foreach (glob(__DIR__.'/../src/Models/*.php') ?: [] as $file) {
            $fqcn = 'Geccomedia\\Weclapp\\Models\\'.basename($file, '.php');
            if (class_exists($fqcn)) {
                $rc = new ReflectionClass($fqcn);
                if (! $rc->isAbstract()) {
                    $table = $rc->newInstanceWithoutConstructor()->getTable();
                    $modelTables[$table] = $fqcn;
                }
            }
        }

        $coveredDefinitions = array_keys(self::DEFINITION_TO_MODELS);
        $uncovered = [];

        foreach (array_keys($definitions) as $definitionName) {
            if (isset($modelTables[$definitionName]) && ! in_array($definitionName, $coveredDefinitions, true)) {
                $uncovered[] = "{$definitionName} ({$modelTables[$definitionName]})";
            }
        }

        $this->assertEmpty(
            $uncovered,
            sprintf(
                "%d swagger definition(s) have a matching model but are not listed in DEFINITION_TO_MODELS:\n  - %s",
                count($uncovered),
                implode("\n  - ", $uncovered),
            )
        );
    }

    /**
     * Every sub-definition in the swagger spec must be listed in
     * SUB_DEFINITION_TO_CLASS so it actually gets tested.
     */
    public function test_all_sub_definitions_are_covered(): void
    {
        $definitions = self::definitions();
        $pathRefs = self::pathRefs();

        $coveredSubDefs = array_keys(self::SUB_DEFINITION_TO_CLASS);
        $coveredTopDefs = array_keys(self::DEFINITION_TO_MODELS);
        $uncovered = [];

        foreach (array_keys($definitions) as $definitionName) {
            // Only check definitions that are NOT reachable via paths.
            if (isset($pathRefs[$definitionName])) {
                continue;
            }

            // Skip if already covered as a top-level model definition.
            if (in_array($definitionName, $coveredTopDefs, true)) {
                continue;
            }

            if (! in_array($definitionName, $coveredSubDefs, true)) {
                $uncovered[] = $definitionName;
            }
        }

        $this->assertEmpty(
            $uncovered,
            sprintf(
                "%d swagger sub-definition(s) are not listed in SUB_DEFINITION_TO_CLASS:\n  - %s",
                count($uncovered),
                implode("\n  - ", $uncovered),
            )
        );
    }

    /**
     * Every property of a swagger sub-definition must be declared as @property
     * on the corresponding sub-model class.
     */
    #[DataProvider('subDefinitionClassPairs')]
    public function test_sub_model_declares_all_swagger_properties(string $definitionName, string $fqcn): void
    {
        $definitions = self::definitions();

        $this->assertArrayHasKey(
            $definitionName,
            $definitions,
            "Swagger sub-definition '{$definitionName}' does not exist in the spec."
        );

        $swaggerProps = $definitions[$definitionName];
        $modelProps = self::modelProperties($fqcn);

        $missing = array_values(array_diff($swaggerProps, $modelProps));

        $this->assertEmpty(
            $missing,
            sprintf(
                "%s is missing %d @property annotation(s) from the '%s' swagger sub-definition:\n  - %s",
                $fqcn,
                count($missing),
                $definitionName,
                implode("\n  - ", $missing),
            )
        );
    }

    /**
     * Every property of a swagger definition must be declared as "@property" on
     * the corresponding model class.
     */
    #[DataProvider('definitionModelPairs')]
    public function test_model_declares_all_swagger_properties(string $definitionName, string $fqcn): void
    {
        $definitions = self::definitions();

        $this->assertArrayHasKey(
            $definitionName,
            $definitions,
            "Swagger definition '{$definitionName}' does not exist in the spec."
        );

        $swaggerProps = $definitions[$definitionName];
        $modelProps = self::modelProperties($fqcn);

        $missing = array_values(array_diff($swaggerProps, $modelProps));

        $this->assertEmpty(
            $missing,
            sprintf(
                "%s is missing %d @property annotation(s) from the '%s' swagger definition:\n  - %s",
                $fqcn,
                count($missing),
                $definitionName,
                implode("\n  - ", $missing),
            )
        );
    }
}
