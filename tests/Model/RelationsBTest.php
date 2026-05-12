<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\AccountingTransaction;
use Geccomedia\Weclapp\Models\BatchNumber;
use Geccomedia\Weclapp\Models\FulfillmentProvider;
use Geccomedia\Weclapp\Models\LedgerAccount;
use Geccomedia\Weclapp\Models\NumberRangeValue;
use Geccomedia\Weclapp\Models\PaymentRun;
use Geccomedia\Weclapp\Models\ProductionWorkScheduleAssignment;
use Geccomedia\Weclapp\Models\ProjectOrderStatusPage;
use Geccomedia\Weclapp\Models\SepaDirectDebitMandate;
use Geccomedia\Weclapp\Models\SerialNumber;
use Geccomedia\Weclapp\Models\StoragePlaceSize;
use Geccomedia\Weclapp\Models\TaskList;
use Geccomedia\Weclapp\Models\TaxDeterminationRule;
use Geccomedia\Weclapp\Models\TermOfPayment;
use Geccomedia\Weclapp\Models\TicketCategory;
use Geccomedia\Weclapp\Models\TicketFaq;
use Geccomedia\Weclapp\Models\TicketStatus;
use Geccomedia\Weclapp\Models\TicketType;
use Geccomedia\Weclapp\Models\VariantArticleVariant;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class RelationsBTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    // ── AccountingTransaction ──────────────────────────────────────────────

    public function test_accounting_transaction_currency(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new AccountingTransaction)->currency());
    }

    // ── BatchNumber ───────────────────────────────────────────────────────

    public function test_batch_number_article(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BatchNumber)->article());
    }

    public function test_batch_number_warehouse(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BatchNumber)->warehouse());
    }

    // ── FulfillmentProvider ───────────────────────────────────────────────

    public function test_fulfillment_provider_warehouse(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new FulfillmentProvider)->warehouse());
    }

    // ── LedgerAccount ─────────────────────────────────────────────────────

    public function test_ledger_account_parent_account(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new LedgerAccount)->parentAccount());
    }

    // ── NumberRangeValue ──────────────────────────────────────────────────

    public function test_number_range_value_number_range(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new NumberRangeValue)->numberRange());
    }

    // ── PaymentRun ────────────────────────────────────────────────────────

    public function test_payment_run_run_by_user(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PaymentRun)->runByUser());
    }

    // ── ProductionWorkScheduleAssignment ──────────────────────────────────

    public function test_production_work_schedule_assignment_article(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ProductionWorkScheduleAssignment)->article());
    }

    public function test_production_work_schedule_assignment_production_work_schedule(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ProductionWorkScheduleAssignment)->productionWorkSchedule());
    }

    // ── ProjectOrderStatusPage ────────────────────────────────────────────

    public function test_project_order_status_page_project_order(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ProjectOrderStatusPage)->projectOrder());
    }

    // ── SepaDirectDebitMandate ────────────────────────────────────────────

    public function test_sepa_direct_debit_mandate_bank_account(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SepaDirectDebitMandate)->bankAccount());
    }

    // ── SerialNumber ──────────────────────────────────────────────────────

    public function test_serial_number_article(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SerialNumber)->article());
    }

    public function test_serial_number_warehouse(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SerialNumber)->warehouse());
    }

    // ── StoragePlaceSize ──────────────────────────────────────────────────

    public function test_storage_place_size_loading_equipment_identifier(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new StoragePlaceSize)->loadingEquipmentIdentifier());
    }

    // ── TaskList ──────────────────────────────────────────────────────────

    public function test_task_list_responsible_user(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TaskList)->responsibleUser());
    }

    // ── TaxDeterminationRule ──────────────────────────────────────────────

    public function test_tax_determination_rule_tax(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TaxDeterminationRule)->tax());
    }

    // ── TermOfPayment ─────────────────────────────────────────────────────

    public function test_term_of_payment_sales_orders(): void
    {
        $this->assertInstanceOf(HasMany::class, (new TermOfPayment)->salesOrders());
    }

    public function test_term_of_payment_purchase_orders(): void
    {
        $this->assertInstanceOf(HasMany::class, (new TermOfPayment)->purchaseOrders());
    }

    // ── TicketCategory ────────────────────────────────────────────────────

    public function test_ticket_category_parent_ticket_category(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TicketCategory)->parentTicketCategory());
    }

    // ── TicketFaq ─────────────────────────────────────────────────────────

    public function test_ticket_faq_created_by(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TicketFaq)->createdBy());
    }

    // ── TicketStatus ──────────────────────────────────────────────────────

    public function test_ticket_status_auto_change_ticket_status(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TicketStatus)->autoChangeTicketStatus());
    }

    public function test_ticket_status_target_status(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TicketStatus)->targetStatus());
    }

    // ── TicketType ────────────────────────────────────────────────────────

    public function test_ticket_type_article(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TicketType)->article());
    }

    // ── VariantArticleVariant ─────────────────────────────────────────────

    public function test_variant_article_variant_article(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new VariantArticleVariant)->article());
    }

    public function test_variant_article_variant_variant_article(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new VariantArticleVariant)->variantArticle());
    }
}
