<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Inventory;
use Geccomedia\Weclapp\Models\InventoryItem;
use Geccomedia\Weclapp\Models\InventoryTransportReference;
use Geccomedia\Weclapp\Models\Shelf;
use Geccomedia\Weclapp\Models\StorageLocation;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class InventoryTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // -------------------------------------------------------------------------
    // Inventory – relations
    // -------------------------------------------------------------------------

    public function test_inventory_inventory_group_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Inventory)->inventoryGroup());
    }

    public function test_inventory_manager_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Inventory)->manager());
    }

    public function test_inventory_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Inventory)->warehouse());
    }

    // -------------------------------------------------------------------------
    // InventoryItem – relations
    // -------------------------------------------------------------------------

    public function test_inventory_item_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new InventoryItem)->article());
    }

    public function test_inventory_item_inventory_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new InventoryItem)->inventory());
    }

    public function test_inventory_item_inventory_transport_reference_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new InventoryItem)->inventoryTransportReference());
    }

    public function test_inventory_item_storage_place_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new InventoryItem)->storagePlace());
    }

    // -------------------------------------------------------------------------
    // InventoryTransportReference – relations
    // -------------------------------------------------------------------------

    public function test_inventory_transport_reference_inventory_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new InventoryTransportReference)->inventory());
    }

    public function test_inventory_transport_reference_loading_equipment_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class,
            (new InventoryTransportReference)->loadingEquipmentArticle());
    }

    public function test_inventory_transport_reference_loading_equipment_identifier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class,
            (new InventoryTransportReference)->loadingEquipmentIdentifier());
    }

    // -------------------------------------------------------------------------
    // StorageLocation – relations
    // -------------------------------------------------------------------------

    public function test_storage_location_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new StorageLocation)->warehouse());
    }

    // -------------------------------------------------------------------------
    // StorageLocation – instance-level POST actions (exists=true)
    // -------------------------------------------------------------------------

    public function test_storage_location_activate_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new StorageLocation;
        $model->exists = true;
        $model->id = '1';
        $model->activate();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:storageLocation/id/1/activate'));
    }

    public function test_storage_location_deactivate_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new StorageLocation;
        $model->exists = true;
        $model->id = '1';
        $model->deactivate();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:storageLocation/id/1/deactivate'));
    }

    // -------------------------------------------------------------------------
    // Shelf – relations
    // -------------------------------------------------------------------------

    public function test_shelf_storage_location_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shelf)->storageLocation());
    }

    // -------------------------------------------------------------------------
    // Shelf – instance-level POST actions (exists=true)
    // -------------------------------------------------------------------------

    public function test_shelf_activate_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new Shelf;
        $model->exists = true;
        $model->id = '1';
        $model->activate();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:shelf/id/1/activate'));
    }

    public function test_shelf_deactivate_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new Shelf;
        $model->exists = true;
        $model->id = '1';
        $model->deactivate();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:shelf/id/1/deactivate'));
    }
}
