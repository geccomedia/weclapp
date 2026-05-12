<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\PurchaseRequisition;
use Geccomedia\Weclapp\Models\Task;
use Geccomedia\Weclapp\Models\Tax;
use Geccomedia\Weclapp\Models\Warehouse;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class Relations1Test extends OrchestraTestCase
{
    use UsesServiceProvider;

    // ── Tax ──────────────────────────────────────────────────────────────────

    public function test_tax_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Tax)->account());
    }

    public function test_tax_contra_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Tax)->contraAccount());
    }

    public function test_tax_default_discount_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Tax)->defaultDiscountAccount());
    }

    public function test_tax_default_nominal_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Tax)->defaultNominalAccount());
    }

    public function test_tax_deposit_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Tax)->depositAccount());
    }

    public function test_tax_sales_orders_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Tax)->salesOrders());
    }

    // ── Task ─────────────────────────────────────────────────────────────────

    public function test_task_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Task)->article());
    }

    public function test_task_calendar_event_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Task)->calendarEvent());
    }

    public function test_task_creator_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Task)->creatorUser());
    }

    public function test_task_customer_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Task)->customer());
    }

    public function test_task_parent_task_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Task)->parentTask());
    }

    public function test_task_previous_task_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Task)->previousTask());
    }

    public function test_task_ticket_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Task)->ticket());
    }

    public function test_task_user_of_last_status_change_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Task)->userOfLastStatusChange());
    }

    // ── PurchaseRequisition ──────────────────────────────────────────────────

    public function test_purchase_requisition_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseRequisition)->article());
    }

    public function test_purchase_requisition_packaging_unit_to_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseRequisition)->packagingUnitToOrder());
    }

    public function test_purchase_requisition_production_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseRequisition)->productionOrder());
    }

    public function test_purchase_requisition_purchase_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseRequisition)->purchaseOrder());
    }

    public function test_purchase_requisition_supplier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseRequisition)->supplier());
    }

    public function test_purchase_requisition_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseRequisition)->warehouse());
    }

    // ── Warehouse ────────────────────────────────────────────────────────────

    public function test_warehouse_default_consolidation_storage_place_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Warehouse)->defaultConsolidationStoragePlace());
    }

    public function test_warehouse_default_production_storage_place_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Warehouse)->defaultProductionStoragePlace());
    }

    public function test_warehouse_default_returns_storage_place_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Warehouse)->defaultReturnsStoragePlace());
    }

    public function test_warehouse_default_storage_place_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Warehouse)->defaultStoragePlace());
    }

    public function test_warehouse_direct_booking_internal_transport_reference_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Warehouse)->directBookingInternalTransportReference());
    }

    public function test_warehouse_warehouse_stock_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Warehouse)->warehouseStock());
    }

    public function test_warehouse_storage_locations_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Warehouse)->storageLocations());
    }

    public function test_warehouse_storage_places_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Warehouse)->storagePlaces());
    }
}
