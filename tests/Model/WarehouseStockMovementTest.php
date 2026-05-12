<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\WarehouseStockMovement;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class WarehouseStockMovementTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    public function test_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new WarehouseStockMovement)->article());
    }

    public function test_batch_number_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new WarehouseStockMovement)->batchNumber());
    }

    public function test_cost_center_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new WarehouseStockMovement)->costCenter());
    }

    public function test_internal_transport_reference_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new WarehouseStockMovement)->internalTransportReference());
    }

    public function test_production_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new WarehouseStockMovement)->productionOrder());
    }

    public function test_storage_place_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new WarehouseStockMovement)->storagePlace());
    }

    public function test_transportation_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new WarehouseStockMovement)->transportationOrder());
    }

    public function test_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new WarehouseStockMovement)->user());
    }

    // -------------------------------------------------------------------------
    // Actions  (collection: /warehouseStockMovement/…  because exists=false)
    // -------------------------------------------------------------------------

    public function test_book_direct_stock_transfer_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new WarehouseStockMovement;
        $model->exists = true;
        $model->id = '1';
        $model->bookDirectStockTransfer();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:warehouseStockMovement/id/1/bookDirectStockTransfer')
        );
    }

    public function test_book_from_loading_equipment_place_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new WarehouseStockMovement;
        $model->exists = true;
        $model->id = '1';
        $model->bookFromLoadingEquipmentPlace();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:warehouseStockMovement/id/1/bookFromLoadingEquipmentPlace')
        );
    }

    public function test_book_incoming_movement_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new WarehouseStockMovement;
        $model->exists = true;
        $model->id = '1';
        $model->bookIncomingMovement();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:warehouseStockMovement/id/1/bookIncomingMovement')
        );
    }

    public function test_book_onto_internal_transport_reference_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new WarehouseStockMovement;
        $model->exists = true;
        $model->id = '1';
        $model->bookOntoInternalTransportReference();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:warehouseStockMovement/id/1/bookOntoInternalTransportReference')
        );
    }

    public function test_book_outgoing_movement_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new WarehouseStockMovement;
        $model->exists = true;
        $model->id = '1';
        $model->bookOutgoingMovement();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:warehouseStockMovement/id/1/bookOutgoingMovement')
        );
    }

    public function test_book_to_loading_equipment_place_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new WarehouseStockMovement;
        $model->exists = true;
        $model->id = '1';
        $model->bookToLoadingEquipmentPlace();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:warehouseStockMovement/id/1/bookToLoadingEquipmentPlace')
        );
    }
}
