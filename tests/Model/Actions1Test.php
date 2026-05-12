<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Opportunity;
use Geccomedia\Weclapp\Models\PurchaseOrderRequest;
use Geccomedia\Weclapp\Models\PurchaseRequisition;
use Geccomedia\Weclapp\Models\Task;
use Geccomedia\Weclapp\Models\Tax;
use Geccomedia\Weclapp\Models\Warehouse;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class Actions1Test extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // ── Tax ──────────────────────────────────────────────────────────────────

    public function test_tax_configure_purchase_taxes_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Tax)->configurePurchaseTaxes();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:tax/configurePurchaseTaxes'));
    }

    public function test_tax_configure_sales_taxes_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Tax)->configureSalesTaxes();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:tax/configureSalesTaxes'));
    }

    public function test_tax_find_purchase_tax_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Tax)->findPurchaseTax();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:tax/findPurchaseTax'));
    }

    public function test_tax_find_sales_tax_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Tax)->findSalesTax();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:tax/findSalesTax'));
    }

    public function test_tax_reset_system_taxes_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Tax)->resetSystemTaxes();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:tax/resetSystemTaxes'));
    }

    // ── Task ─────────────────────────────────────────────────────────────────

    public function test_task_create_performance_record_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Task)->createPerformanceRecord();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:task/createPerformanceRecord'));
    }

    public function test_task_update_billing_data_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Task)->updateBillingData();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:task/updateBillingData'));
    }

    public function test_task_from_template_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Task)->fromTemplate();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:task/fromTemplate'));
    }

    // ── PurchaseRequisition ──────────────────────────────────────────────────

    public function test_purchase_requisition_add_to_internal_shipment_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new PurchaseRequisition)->addToInternalShipment();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseRequisition/addToInternalShipment'));
    }

    public function test_purchase_requisition_add_to_purchase_order_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new PurchaseRequisition)->addToPurchaseOrder();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseRequisition/addToPurchaseOrder'));
    }

    public function test_purchase_requisition_create_production_order_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new PurchaseRequisition)->createProductionOrder();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseRequisition/createProductionOrder'));
    }

    public function test_purchase_requisition_delete_all_requisitions_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new PurchaseRequisition)->deleteAllRequisitions();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseRequisition/deleteAllRequisitions'));
    }

    public function test_purchase_requisition_start_material_planning_run_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new PurchaseRequisition)->startMaterialPlanningRun();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseRequisition/startMaterialPlanningRun'));
    }

    // ── Warehouse ────────────────────────────────────────────────────────────

    public function test_warehouse_activate_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Warehouse)->activate();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:warehouse/activate'));
    }

    public function test_warehouse_deactivate_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Warehouse)->deactivate();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:warehouse/deactivate'));
    }

    // ── PurchaseOrderRequest ─────────────────────────────────────────────────

    public function test_purchase_order_request_create_blanket_purchase_order_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new PurchaseOrderRequest)->createBlanketPurchaseOrder();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOrderRequest/createBlanketPurchaseOrder'));
    }

    public function test_purchase_order_request_create_purchase_order_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new PurchaseOrderRequest)->createPurchaseOrder();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOrderRequest/createPurchaseOrder'));
    }

    public function test_purchase_order_request_export_items_as_csv_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new PurchaseOrderRequest)->exportItemsAsCsv();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOrderRequest/exportItemsAsCsv'));
    }

    public function test_purchase_order_request_push_purchase_prices_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new PurchaseOrderRequest)->pushPurchasePrices();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOrderRequest/pushPurchasePrices'));
    }

    // ── Opportunity ──────────────────────────────────────────────────────────

    public function test_opportunity_link_quotation_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Opportunity)->linkQuotation();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:opportunity/linkQuotation'));
    }
}
