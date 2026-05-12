<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\Shipment;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ShipmentTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // -------------------------------------------------------------------------
    // BelongsTo relations
    // -------------------------------------------------------------------------

    public function test_consolidation_storage_place_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->consolidationStoragePlace());
    }

    public function test_creator_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->creator());
    }

    public function test_declared_value_amount_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->declaredValueAmountCurrency());
    }

    public function test_destination_storage_place_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->destinationStoragePlace());
    }

    public function test_destination_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->destinationWarehouse());
    }

    public function test_invoice_recipient_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->invoiceRecipient());
    }

    public function test_main_sales_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->mainSalesOrder());
    }

    public function test_recipient_party_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->recipientParty());
    }

    public function test_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->responsibleUser());
    }

    public function test_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->shipmentMethod());
    }

    public function test_shipping_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->shippingCarrier());
    }

    public function test_shipping_return_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->shippingReturnCarrier());
    }

    public function test_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->warehouse());
    }

    public function test_customer_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->customer());
    }

    public function test_sales_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->salesOrder());
    }

    public function test_fulfillment_provider_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Shipment)->fulfillmentProvider());
    }

    // -------------------------------------------------------------------------
    // Instance-level actions (POST/GET, exists=true)
    // -------------------------------------------------------------------------

    private function makeShipment(): Shipment
    {
        $m = new Shipment;
        $m->exists = true;
        $m->id = '1';

        return $m;
    }

    public function test_create_picking_list_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeShipment()->createPickingList();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:shipment/id/1/createPickingList'));
    }

    public function test_create_picking_order_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeShipment()->createPickingOrder();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:shipment/id/1/createPickingOrder'));
    }

    public function test_create_return_labels_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeShipment()->createReturnLabels();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:shipment/id/1/createReturnLabels'));
    }

    public function test_create_sales_invoice_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeShipment()->createSalesInvoice();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:shipment/id/1/createSalesInvoice'));
    }

    public function test_create_shipping_label_pdf_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeShipment()->createShippingLabelPdf();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:shipment/id/1/createShippingLabelPdf'));
    }

    public function test_create_shipping_labels_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeShipment()->createShippingLabels();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:shipment/id/1/createShippingLabels'));
    }

    public function test_download_latest_delivery_note_pdf_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeShipment()->downloadLatestDeliveryNotePdf();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:shipment/id/1/downloadLatestDeliveryNotePdf'));
    }

    public function test_download_latest_picking_list_pdf_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeShipment()->downloadLatestPickingListPdf();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:shipment/id/1/downloadLatestPickingListPdf'));
    }

    public function test_download_latest_shipping_label_pdf_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeShipment()->downloadLatestShippingLabelPdf();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:shipment/id/1/downloadLatestShippingLabelPdf'));
    }

    public function test_print_label_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeShipment()->printLabel();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:shipment/id/1/printLabel'));
    }
}
