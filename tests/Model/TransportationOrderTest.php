<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\TransportationOrder;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TransportationOrderTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    public function test_assigned_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TransportationOrder)->assignedUser());
    }

    public function test_destination_storage_place_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TransportationOrder)->destinationStoragePlace());
    }

    public function test_internal_transport_reference_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TransportationOrder)->internalTransportReference());
    }

    public function test_loading_equipment_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TransportationOrder)->loadingEquipmentArticle());
    }

    public function test_loading_equipment_identifier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TransportationOrder)->loadingEquipmentIdentifier());
    }

    public function test_production_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TransportationOrder)->productionOrder());
    }

    public function test_shipment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TransportationOrder)->shipment());
    }

    // -------------------------------------------------------------------------
    // Actions  (instance: /transportationOrder/id/{id}/…)
    // -------------------------------------------------------------------------

    public function test_add_picks_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new TransportationOrder;
        $model->exists = true;
        $model->id = '1';
        $model->addPicks();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:transportationOrder/id/1/addPicks')
        );
    }

    public function test_create_pick_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new TransportationOrder;
        $model->exists = true;
        $model->id = '1';
        $model->createPick();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:transportationOrder/id/1/createPick')
        );
    }

    public function test_create_picking_list_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new TransportationOrder;
        $model->exists = true;
        $model->id = '1';
        $model->createPickingList();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:transportationOrder/id/1/createPickingList')
        );
    }

    public function test_create_transportation_order_from_unpicked_records_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new TransportationOrder;
        $model->exists = true;
        $model->id = '1';
        $model->createTransportationOrderFromUnpickedRecords();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:transportationOrder/id/1/createTransportationOrderFromUnpickedRecords')
        );
    }

    public function test_internal_transport_references_for_pick_up_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new TransportationOrder;
        $model->exists = true;
        $model->id = '1';
        $model->internalTransportReferencesForPickUp();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:transportationOrder/id/1/internalTransportReferencesForPickUp')
        );
    }

    public function test_pick_pick_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new TransportationOrder;
        $model->exists = true;
        $model->id = '1';
        $model->pickPick();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:transportationOrder/id/1/pickPick')
        );
    }

    public function test_put_down_internal_transport_reference_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new TransportationOrder;
        $model->exists = true;
        $model->id = '1';
        $model->putDownInternalTransportReference();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:transportationOrder/id/1/putDownInternalTransportReference')
        );
    }
}
