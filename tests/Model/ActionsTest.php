<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\InternalTransportReference;
use Geccomedia\Weclapp\Models\Inventory;
use Geccomedia\Weclapp\Models\Meta;
use Geccomedia\Weclapp\Models\ProductionOrder;
use Geccomedia\Weclapp\Models\ServiceQuota;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ActionsTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // -------------------------------------------------------------------------
    // ServiceQuota relations
    // -------------------------------------------------------------------------

    public function test_service_quota_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ServiceQuota)->article());
    }

    public function test_service_quota_customer_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ServiceQuota)->customer());
    }

    // -------------------------------------------------------------------------
    // ServiceQuota actions (instance-level POST)
    // -------------------------------------------------------------------------

    public function test_service_quota_close_post_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(ServiceQuota::class)->close();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:serviceQuota/id/1/close'));
    }

    public function test_service_quota_create_performance_record_post_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(ServiceQuota::class)->createPerformanceRecord();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:serviceQuota/id/1/createPerformanceRecord'));
    }

    public function test_service_quota_open_post_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(ServiceQuota::class)->open();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:serviceQuota/id/1/open'));
    }

    // -------------------------------------------------------------------------
    // Meta actions (collection-level GET, exists=false)
    // -------------------------------------------------------------------------

    public function test_meta_legacy_reference_properties_get_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Meta)->legacyReferenceProperties();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:meta/legacyReferenceProperties'));
    }

    public function test_meta_query_filter_properties_get_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Meta)->queryFilterProperties();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:meta/queryFilterProperties'));
    }

    public function test_meta_query_sort_properties_get_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Meta)->querySortProperties();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:meta/querySortProperties'));
    }

    public function test_meta_resources_get_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Meta)->resources();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:meta/resources'));
    }

    public function test_meta_validation_error_codes_get_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Meta)->validationErrorCodes();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:meta/validationErrorCodes'));
    }

    // -------------------------------------------------------------------------
    // Inventory actions (instance-level POST)
    // -------------------------------------------------------------------------

    public function test_inventory_book_inventory_post_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(Inventory::class)->bookInventory();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:inventory/id/1/bookInventory'));
    }

    public function test_inventory_create_post_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(Inventory::class)->create();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:inventory/id/1/create'));
    }

    // -------------------------------------------------------------------------
    // InternalTransportReference actions
    // -------------------------------------------------------------------------

    public function test_internal_transport_reference_create_label_post_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(InternalTransportReference::class)->createLabel();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:internalTransportReference/id/1/createLabel'));
    }

    public function test_internal_transport_reference_download_latest_label_get_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(InternalTransportReference::class)->downloadLatestLabel();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:internalTransportReference/id/1/downloadLatestLabel'));
    }

    // -------------------------------------------------------------------------
    // ProductionOrder actions (instance-level POST / GET)
    // -------------------------------------------------------------------------

    public function test_production_order_create_picking_list_post_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(ProductionOrder::class)->createPickingList();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:productionOrder/id/1/createPickingList'));
    }

    public function test_production_order_create_picking_order_post_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(ProductionOrder::class)->createPickingOrder();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:productionOrder/id/1/createPickingOrder'));
    }

    public function test_production_order_download_latest_production_order_pdf_get_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(ProductionOrder::class)->downloadLatestProductionOrderPdf();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:productionOrder/id/1/downloadLatestProductionOrderPdf'));
    }

    public function test_production_order_fast_production_booking_post_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(ProductionOrder::class)->fastProductionBooking();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:productionOrder/id/1/fastProductionBooking'));
    }
}
