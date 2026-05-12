<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\SalesOrder;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Covers the second batch of SalesOrder action methods (instance POST/GET).
 * All actions below operate on an existing instance (exists=true, id='1'),
 * except defaultValuesForCreate which is a collection-level GET.
 */
class SalesOrderActions2Test extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    private function makeOrder(): SalesOrder
    {
        $order = new SalesOrder;
        $order->exists = true;
        $order->id = '1';

        return $order;
    }

    public function test_create_shipment_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createShipment();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/createShipment'));
    }

    public function test_create_shipping_labels_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createShippingLabels();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/createShippingLabels'));
    }

    public function test_manually_close_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->manuallyClose();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/manuallyClose'));
    }

    public function test_preview_sales_order_confirmation_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->previewSalesOrderConfirmation();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:salesOrder/id/1/previewSalesOrderConfirmation'));
    }

    public function test_print_label_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->printLabel();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/printLabel'));
    }

    public function test_print_order_data_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->printOrderData();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:salesOrder/id/1/printOrderData'));
    }

    public function test_recalculate_costs_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->recalculateCosts();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/recalculateCosts'));
    }

    public function test_reset_taxes_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->resetTaxes();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/resetTaxes'));
    }

    public function test_set_costs_for_items_without_cost_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->setCostsForItemsWithoutCost();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/setCostsForItemsWithoutCost'));
    }

    public function test_ship_order_for_external_fulfillment_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->shipOrderForExternalFulfillment();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/shipOrderForExternalFulfillment'));
    }

    public function test_toggle_project_team_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->toggleProjectTeam();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/toggleProjectTeam'));
    }

    public function test_toggle_services_finished_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->toggleServicesFinished();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/toggleServicesFinished'));
    }

    public function test_update_prices_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->updatePrices();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/updatePrices'));
    }

    public function test_download_latest_order_confirmation_pdf_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->downloadLatestOrderConfirmationPdf();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:salesOrder/id/1/downloadLatestOrderConfirmationPdf'));
    }

    public function test_default_values_for_create_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $order = new SalesOrder;
        $order->exists = false;
        $order->defaultValuesForCreate();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:salesOrder/defaultValuesForCreate'));
    }
}
