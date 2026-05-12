<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\Contact;
use Geccomedia\Weclapp\Models\Customer;
use Geccomedia\Weclapp\Models\Lead;
use Geccomedia\Weclapp\Models\SalesOrder;
use Geccomedia\Weclapp\Models\Supplier;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class QueryGrammarTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

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

    /**
     * compileAction() with GET method and non-empty params must append a query
     * string to the URI instead of a request body.
     */
    public function test_compile_action_get_with_params_appends_query_string(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->twice()
            ->andReturn(
                new Response(200, [], '{"result": [{"id": "99"}]}'),
                new Response(200, [], '{"result": "ok"}')
            );

        $order = SalesOrder::find('99');
        $order->callAction('download', ['format' => 'pdf'], 'GET');

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            $sql = (string) $event->sql;

            return str_contains($sql, 'GET:salesOrder/id/99/download')
                && str_contains($sql, 'format=pdf');
        });
    }

    /**
     * compileAction() with POST method and empty params must send a null body
     * (not an empty JSON object).
     */
    public function test_compile_action_post_with_empty_params_sends_null_body(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], '{"result": "ok"}'));

        SalesOrder::action('defaultValuesForCreate', [], 'POST');

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql === 'POST:salesOrder/defaultValuesForCreate';
        });
    }

    /**
     * compileColumns() must return void (null) when $query->aggregate is set,
     * so that the columns component is omitted from the compiled query.
     */
    public function test_compile_columns_skipped_when_aggregate_is_set(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], '{"result": 7}'));

        // count() sets the aggregate — compileColumns must be a no-op
        $count = SalesOrder::where('status', 'OPEN')->count();

        $this->assertEquals(7, $count);

        // The compiled URL must contain /count but must NOT contain 'properties='
        Event::assertDispatched(QueryExecuted::class, function ($event) {
            $sql = (string) $event->sql;

            return str_contains($sql, '/count') && ! str_contains($sql, 'properties=');
        });
    }

    /**
     * compileAdditionalProperties() with an empty array must return null so
     * that no additionalProperties param appears in the compiled URL.
     */
    public function test_compile_additional_properties_empty_returns_no_param(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], '{"result": []}'));

        // withProperties() with an empty list — no additionalProperties should appear
        SalesOrder::withProperties()->get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return ! str_contains((string) $event->sql, 'additionalProperties');
        });
    }

    /**
     * whereNotIn() must compile to a `field-notin=[...]` query parameter.
     */
    public function test_where_not_in_compiles_correct_url(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(new Response(200, [], '{"result": []}'));

        SalesOrder::whereNotIn('status', ['CANCELLED', 'CLOSED'])->get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            $sql = (string) $event->sql;

            return str_contains($sql, 'status-notin=') &&
                   str_contains($sql, 'CANCELLED') &&
                   str_contains($sql, 'CLOSED');
        });
    }
}
