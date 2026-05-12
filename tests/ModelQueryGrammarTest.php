<?php

namespace Geccomedia\Weclapp\Tests;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\Contact;
use Geccomedia\Weclapp\Models\Customer;
use Geccomedia\Weclapp\Models\Lead;
use Geccomedia\Weclapp\Models\SalesOrder;
use Geccomedia\Weclapp\Models\Supplier;
use Geccomedia\Weclapp\ServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ModelQueryGrammarTest extends OrchestraTestCase
{
    /**
     * @param  Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    /**
     * withProperties() must append additionalProperties=... to the compiled URL.
     */
    public function test_with_properties_compiles_correct_url(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], '{"result": []}'));

        SalesOrder::withProperties('orderItems', 'tags')
            ->where('status', 'OPEN')
            ->get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            $sql = (string) $event->sql;

            return str_contains($sql, 'additionalProperties=orderItems%2Ctags') ||
                   str_contains($sql, 'additionalProperties=orderItems,tags');
        });
    }

    /**
     * SalesOrder::action('defaultValuesForCreate') must POST to salesOrder/defaultValuesForCreate.
     */
    public function test_collection_action_dispatches_correct_sql(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], '{"result": "ok"}'));

        SalesOrder::action('defaultValuesForCreate');

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql === 'POST:salesOrder/defaultValuesForCreate';
        });
    }

    /**
     * Calling callAction('createShipment') on an instance must POST to
     * salesOrder/id/{id}/createShipment.
     */
    public function test_instance_call_action_dispatches_correct_sql(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->twice()
            ->andReturn(
                new Response(200, [], '{"result": [{"id": "1"}]}'),
                new Response(200, [], '{"result": "ok"}')
            );

        $order = SalesOrder::find('1');

        $order->newQuery()->callAction('createShipment', ['shipmentMethodId' => 'abc']);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql === 'POST:salesOrder/id/1/createShipment';
        });
    }

    public function test_boolean_true_serializes_to_string_true(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(new Response(200, [], '{"result": []}'));

        Customer::where('customer', true)->get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return str_contains((string) $event->sql, 'customer-eq=true');
        });
    }

    public function test_boolean_false_serializes_to_string_false(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(new Response(200, [], '{"result": []}'));

        Customer::where('customerBlocked', false)->get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return str_contains((string) $event->sql, 'customerBlocked-eq=false');
        });
    }

    public function test_boolean_in_wherein_values_serializes_correctly(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(new Response(200, [], '{"result": []}'));

        Customer::whereIn('customerBlocked', [true, false])->get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            $sql = (string) $event->sql;

            // JSON-encoded array of the string-ified booleans
            return str_contains($sql, 'customerBlocked-in=') && str_contains($sql, 'true') && str_contains($sql, 'false');
        });
    }

    public function test_customer_scope_appends_customer_filter(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(new Response(200, [], '{"result": []}'));

        Customer::get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return str_contains((string) $event->sql, 'customer-eq=true');
        });
    }

    public function test_supplier_scope_appends_supplier_filter(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(new Response(200, [], '{"result": []}'));

        Supplier::get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return str_contains((string) $event->sql, 'supplier-eq=true');
        });
    }

    public function test_lead_scope_appends_leadstatus_filters(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(new Response(200, [], '{"result": []}'));

        Lead::get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            $sql = (string) $event->sql;

            return str_contains($sql, 'leadStatus-notnull=')
                && str_contains($sql, 'leadStatus-ne=CONVERTED');
        });
    }

    public function test_contact_scope_appends_partytype_filter(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(new Response(200, [], '{"result": []}'));

        Contact::get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return str_contains((string) $event->sql, 'partyType-eq=PERSON');
        });
    }

    public function test_scope_stacks_with_additional_where(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(new Response(200, [], '{"result": []}'));

        Customer::where('company', 'Acme')->get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            $sql = (string) $event->sql;

            return str_contains($sql, 'customer-eq=true')
                && str_contains($sql, 'company-eq=Acme');
        });
    }
}
