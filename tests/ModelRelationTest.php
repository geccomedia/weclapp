<?php

namespace Geccomedia\Weclapp\Tests;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\Currency;
use Geccomedia\Weclapp\Models\Customer;
use Geccomedia\Weclapp\Models\SalesOrder;
use Geccomedia\Weclapp\Models\Shipment;
use Geccomedia\Weclapp\ServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ModelRelationTest extends OrchestraTestCase
{
    /**
     * @param  Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    /**
     * with('relation') must issue exactly ONE batched request for the related
     * model, not one per parent — i.e. it must NOT be N+1.
     *
     * The batched query uses id-in=[...] to fetch all related records at once.
     */
    public function test_eager_load_issues_single_batched_request(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->twice()  // exactly 2: one for salesOrder list, one batched party lookup
            ->andReturn(
                // First call: fetch the sales orders
                new Response(200, [], '{"result": [
                    {"id": "1", "customerId": "100"},
                    {"id": "2", "customerId": "101"},
                    {"id": "3", "customerId": "100"}
                ]}'),
                // Second call: batched fetch of unique customer IDs
                new Response(200, [], '{"result": [
                    {"id": "100", "company": "Acme"},
                    {"id": "101", "company": "Globex"}
                ]}')
            );

        $orders = SalesOrder::with('customer')->get();

        // Confirm the batched query used id-in with the two unique IDs
        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return str_contains((string) $event->sql, 'id-in=') &&
                   str_contains((string) $event->sql, '100') &&
                   str_contains((string) $event->sql, '101');
        });

        // Relations are correctly hydrated
        $this->assertSame('Acme', $orders->find('1')->customer->company);
        $this->assertSame('Globex', $orders->find('2')->customer->company);
        // Duplicate foreign key (100) reuses the same loaded instance — no extra request
        $this->assertSame('Acme', $orders->find('3')->customer->company);
    }

    /**
     * Without with(), each relation access fires its own request — N+1.
     * This test documents and proves the lazy-loading (N+1) behaviour.
     */
    public function test_lazy_load_issues_one_request_per_relation_access(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->times(3)  // 1 list + 2 individual lookups
            ->andReturn(
                new Response(200, [], '{"result": [{"id": "1", "customerId": "100"}, {"id": "2", "customerId": "101"}]}'),
                new Response(200, [], '{"result": [{"id": "100", "company": "Acme"}]}'),
                new Response(200, [], '{"result": [{"id": "101", "company": "Globex"}]}')
            );

        $orders = SalesOrder::get();

        // Each access triggers a separate request
        $this->assertSame('Acme', $orders->find('1')->customer->company);
        $this->assertSame('Globex', $orders->find('2')->customer->company);

        // Three distinct queries were fired
        Event::assertDispatched(QueryExecuted::class, 3);
    }

    /**
     * Shipment::customer() fires GET:customer?id-eq=X
     * SalesOrder::currency() fires GET:currency?id-eq=X
     */
    public function test_belongs_to_relations_compile_correct_queries(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->times(4)  // fetch shipment + customer + salesOrder + currency
            ->andReturn(
                new Response(200, [], '{"result": [{"id": "10", "customerId": "99"}]}'),
                new Response(200, [], '{"result": [{"id": "99", "company": "Acme", "partyType": "ORGANIZATION"}]}'),
                new Response(200, [], '{"result": [{"id": "20", "currencyId": "55"}]}'),
                new Response(200, [], '{"result": [{"id": "55", "isoCode": "EUR"}]}')
            );

        $shipment = Shipment::find('10');
        $customer = $shipment->customer;

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            $sql = (string) $event->sql;

            // Customer/$table = 'party', so BelongsTo routes to 'party'
            return str_contains($sql, 'GET:party') && str_contains($sql, 'id-eq=99');
        });

        $this->assertEquals('Acme', $customer->company);

        $order = SalesOrder::find('20');
        $currency = $order->currency;

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            $sql = (string) $event->sql;

            // BelongsTo uses getQualifiedOwnerKeyName() → 'currency.id'
            return str_contains($sql, 'GET:currency') && str_contains($sql, 'id-eq=55');
        });

        $this->assertEquals('EUR', $currency->isoCode);
    }

    /**
     * $customer->salesOrders()->get() must compile to
     * GET:salesOrder?customerId-eq={id}&pageSize=100
     */
    public function test_has_many_sales_orders_compiles_correct_query(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->twice()
            ->andReturn(
                new Response(200, [], '{"result": [{"id": "1", "company": "Acme"}]}'),
                new Response(200, [], '{"result": [{"id": "10"}, {"id": "11"}]}')
            );

        $customer = Customer::find('1');
        $orders = $customer->salesOrders()->get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            $sql = (string) $event->sql;

            // HasMany uses qualifyColumn() on the related model → 'salesOrder.customerId'
            return str_contains($sql, 'GET:salesOrder') && str_contains($sql, 'customerId-eq=1');
        });

        $this->assertCount(2, $orders);
    }
}
