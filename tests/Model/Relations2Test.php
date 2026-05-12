<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\ArticleCategory;
use Geccomedia\Weclapp\Models\BankTransaction;
use Geccomedia\Weclapp\Models\Opportunity;
use Geccomedia\Weclapp\Models\PurchaseOrderRequest;
use Geccomedia\Weclapp\Models\TimeRecord;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class Relations2Test extends OrchestraTestCase
{
    use UsesServiceProvider;

    // ── TimeRecord ───────────────────────────────────────────────────────────

    public function test_time_record_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TimeRecord)->article());
    }

    public function test_time_record_customer_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TimeRecord)->customer());
    }

    public function test_time_record_sales_invoice_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TimeRecord)->salesInvoice());
    }

    public function test_time_record_sales_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TimeRecord)->salesOrder());
    }

    public function test_time_record_sales_order_ticket_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TimeRecord)->salesOrderTicket());
    }

    public function test_time_record_service_quota_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TimeRecord)->serviceQuota());
    }

    public function test_time_record_task_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TimeRecord)->task());
    }

    public function test_time_record_ticket_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TimeRecord)->ticket());
    }

    public function test_time_record_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TimeRecord)->user());
    }

    public function test_time_record_place_of_service_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TimeRecord)->placeOfService());
    }

    // ── BankTransaction ──────────────────────────────────────────────────────

    public function test_bank_transaction_account_for_costs_of_monetary_traffic_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BankTransaction)->accountForCostsOfMonetaryTraffic());
    }

    public function test_bank_transaction_account_for_dunning_fee_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BankTransaction)->accountForDunningFee());
    }

    public function test_bank_transaction_created_by_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BankTransaction)->createdBy());
    }

    public function test_bank_transaction_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BankTransaction)->currency());
    }

    public function test_bank_transaction_external_connection_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BankTransaction)->externalConnection());
    }

    public function test_bank_transaction_party_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BankTransaction)->party());
    }

    public function test_bank_transaction_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BankTransaction)->paymentMethod());
    }

    public function test_bank_transaction_payment_tolerance_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BankTransaction)->paymentToleranceAccount());
    }

    // ── ArticleCategory ──────────────────────────────────────────────────────

    public function test_article_category_cost_type_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ArticleCategory)->costType());
    }

    public function test_article_category_parent_category_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ArticleCategory)->parentCategory());
    }

    public function test_article_category_purchase_cost_center_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ArticleCategory)->purchaseCostCenter());
    }

    public function test_article_category_sales_cost_center_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ArticleCategory)->salesCostCenter());
    }

    public function test_article_category_article_accounting_code_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ArticleCategory)->articleAccountingCode());
    }

    public function test_article_category_article_category_classification_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ArticleCategory)->articleCategoryClassification());
    }

    // ── PurchaseOrderRequest ─────────────────────────────────────────────────

    public function test_purchase_order_request_creator_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrderRequest)->creator());
    }

    public function test_purchase_order_request_quotation_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrderRequest)->quotation());
    }

    public function test_purchase_order_request_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrderRequest)->responsibleUser());
    }

    public function test_purchase_order_request_sales_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrderRequest)->salesOrder());
    }

    public function test_purchase_order_request_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrderRequest)->warehouse());
    }

    // ── Opportunity ──────────────────────────────────────────────────────────

    public function test_opportunity_contact_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Opportunity)->contact());
    }

    public function test_opportunity_creator_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Opportunity)->creator());
    }

    public function test_opportunity_customer_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Opportunity)->customer());
    }

    public function test_opportunity_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Opportunity)->responsibleUser());
    }

    public function test_opportunity_sales_stage_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Opportunity)->salesStage());
    }

    public function test_opportunity_win_loss_reason_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Opportunity)->winLossReason());
    }

    public function test_opportunity_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Opportunity)->currency());
    }
}
