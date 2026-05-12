<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\IncomingGoods;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class IncomingGoodsTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // -------------------------------------------------------------------------
    // BelongsTo relations
    // -------------------------------------------------------------------------

    public function test_creator_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new IncomingGoods)->creator());
    }

    public function test_dropshipping_shipment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new IncomingGoods)->dropshippingShipment());
    }

    public function test_invoice_recipient_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new IncomingGoods)->invoiceRecipient());
    }

    public function test_related_shipment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new IncomingGoods)->relatedShipment());
    }

    public function test_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new IncomingGoods)->responsibleUser());
    }

    public function test_sender_party_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new IncomingGoods)->senderParty());
    }

    public function test_shipping_return_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new IncomingGoods)->shippingReturnCarrier());
    }

    public function test_source_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new IncomingGoods)->sourceWarehouse());
    }

    public function test_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new IncomingGoods)->warehouse());
    }

    public function test_supplier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new IncomingGoods)->supplier());
    }

    public function test_purchase_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new IncomingGoods)->purchaseOrder());
    }

    // -------------------------------------------------------------------------
    // Instance-level actions (POST/GET, exists=true)
    // -------------------------------------------------------------------------

    private function makeIncomingGoods(): IncomingGoods
    {
        $m = new IncomingGoods;
        $m->exists = true;
        $m->id = '1';

        return $m;
    }

    public function test_add_purchase_orders_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeIncomingGoods()->addPurchaseOrders();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:incomingGoods/id/1/addPurchaseOrders'));
    }

    public function test_create_compensation_shipment_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeIncomingGoods()->createCompensationShipment();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:incomingGoods/id/1/createCompensationShipment'));
    }

    public function test_create_credit_note_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeIncomingGoods()->createCreditNote();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:incomingGoods/id/1/createCreditNote'));
    }

    public function test_create_purchase_invoice_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeIncomingGoods()->createPurchaseInvoice();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:incomingGoods/id/1/createPurchaseInvoice'));
    }

    public function test_create_return_labels_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeIncomingGoods()->createReturnLabels();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:incomingGoods/id/1/createReturnLabels'));
    }

    public function test_create_supplier_return_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeIncomingGoods()->createSupplierReturn();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:incomingGoods/id/1/createSupplierReturn'));
    }

    public function test_incoming_bookings_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeIncomingGoods()->incomingBookings();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:incomingGoods/id/1/incomingBookings'));
    }

    public function test_update_incoming_bookings_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeIncomingGoods()->updateIncomingBookings();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:incomingGoods/id/1/updateIncomingBookings'));
    }
}
