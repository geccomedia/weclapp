<?php

namespace Geccomedia\Weclapp\Tests;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Connection;
use Geccomedia\Weclapp\JobApi;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\Models\CashAccount;
use Geccomedia\Weclapp\Models\Comment;
use Geccomedia\Weclapp\Models\Contact;
use Geccomedia\Weclapp\Models\Currency;
use Geccomedia\Weclapp\Models\Customer;
use Geccomedia\Weclapp\Models\Lead;
use Geccomedia\Weclapp\Models\SalesInvoice;
use Geccomedia\Weclapp\Models\SalesOrder;
use Geccomedia\Weclapp\Models\Shipment;
use Geccomedia\Weclapp\Models\Supplier;
use Geccomedia\Weclapp\Models\Unit;
use Geccomedia\Weclapp\Models\WarehouseStock;
use Geccomedia\Weclapp\NotSupportedException;
use Geccomedia\Weclapp\ServiceProvider;
use Geccomedia\Weclapp\SubModel;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Geccomedia\Weclapp\SubModels\SalesOrderItem;
use Geccomedia\Weclapp\SystemApi;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ModelTest extends OrchestraTestCase
{
    /**
     * Load package service provider
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    /**
     * @var Model
     */
    private $model;

    protected function setUp(): void
    {
        $this->model = new Unit;
        parent::setUp();
    }

    public function test_date_format_on_base_model()
    {
        $this->assertTrue($this->model->getDateFormat() == 'Uv');
    }

    public function test_created_at_const()
    {
        $this->assertTrue(Model::CREATED_AT == 'createdDate');
    }

    public function test_updated_at_const()
    {
        $this->assertTrue(Model::UPDATED_AT == 'lastModifiedDate');
    }

    public function test_date_conversion()
    {
        Event::fake();

        $now = now();

        $this->assertEquals($now->format('Uv'), $this->model->fromDateTime($now->format('Uv')));
        $this->assertEquals($now->format('Uv'), $this->model->fromDateTime($now));

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1, "invoiceDate": '.$now->format('Uv').'}]}'
            ));

        $invoice = SalesInvoice::find(1);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'GET:salesInvoice?id-eq=1&pageSize=1';
        });

        $this->assertEquals($now->format('Uv'), $invoice->invoiceDate->format('Uv'));

        $new_invoice = new SalesInvoice;
        $new_invoice->invoiceDate = $now->toDateString();
        $this->assertEquals($now->startOfDay(), $new_invoice->invoiceDate);
    }

    public function test_api_get()
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1},{"id": 2}]}'
            ));

        $units = Unit::select('1')
            ->where('2', 3)
            ->orderBy(4, 'DESC')
            ->limit(5)
            ->skip(4)
            ->get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'GET:unit?2-eq=3&properties=1&sort=-4&page=1&pageSize=5';
        });

        $this->assertEquals(2, $units->count());

        $this->assertEquals(1, $units->first()->id);
    }

    public function test_api_get_entity()
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1},{"id": 2}]}'
            ));

        $comments = Comment::select('1')
            ->whereEntity('customer', 3)
            ->orderBy(4, 'DESC')
            ->limit(5)
            ->skip(4)
            ->get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'GET:comment?entityName=customer&entityId=3&properties=1&sort=-4&page=1&pageSize=5';
        });

        $this->assertEquals(2, $comments->count());

        $this->assertEquals(1, $comments->first()->id);

        $this->expectException(NotSupportedException::class);

        $units = Unit::select('1')
            ->whereEntity('customer', 3)
            ->orderBy(4, 'DESC')
            ->limit(5)
            ->skip(4)
            ->get();
    }

    public function test_not_found()
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(404));

        $unit = Unit::find(1);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'GET:unit?id-eq=1&pageSize=1';
        });

        $this->assertNull($unit);
    }

    public function test_api_get_all()
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1},{"id": 2}]}'
            ));

        $units = Unit::whereNotIn('test', [1, 2])
            ->whereNull('test2')
            ->whereNotNull('test3')
            ->get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'GET:unit?test-notin=%5B1,2%5D&test2-null=&test3-notnull=&pageSize=100';
        });

        $this->assertEquals(2, $units->count());
    }

    public function test_api_get_empty()
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": []}'
            ));

        $units = Unit::whereNotIn('test', [1, 2])
            ->whereNull('test2')
            ->whereNotNull('test3')
            ->get();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'GET:unit?test-notin=%5B1,2%5D&test2-null=&test3-notnull=&pageSize=100';
        });

        $this->assertEquals(0, $units->count());
    }

    public function test_api_count()
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": 55}'
            ));

        $count = Unit::where('1', 2)->count();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'GET:unit/count?1-eq=2&pageSize=100';
        });

        $this->assertEquals(55, $count);
    }

    public function test_find_many()
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1},{"id": 2}]}'
            ));

        $units = Unit::findMany([1, 2]);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'GET:unit?id-in=%5B1,2%5D&pageSize=100';
        });

        $this->assertEquals(2, $units->count());

        $this->assertEquals(1, $units->first()->id);
    }

    public function test_api_delete()
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(204));

        $deleted = Unit::whereKey(1)
            ->delete();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'DELETE:unit/id/1';
        });

        $this->assertTrue($deleted);

        $this->expectException(NotSupportedException::class);

        Unit::where('this', 'that')
            ->delete();
    }

    public function test_api_insert()
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(new Response(
                201,
                [],
                '{"id": 1, "test": "bla", "remote": "test"}'
            ));

        $unit = new Unit;
        $unit->test = 'bla';
        $unit->save();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'POST:unit' &&
                $event->bindings == ['test' => 'bla'];
        });

        $this->assertTrue($unit->exists);
        $this->assertEquals(1, $unit->id);
        $this->assertEquals('bla', $unit->test);
        $this->assertEquals('test', $unit->remote);

        Unit::insert(['test' => 1]);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'POST:unit' &&
                $event->bindings == ['test' => 1];
        });
    }

    public function test_api_multi_insert()
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(
                new Response(
                    201,
                    [],
                    '{"id": 1, "test": "1", "remote": "test"}'
                ),
                new Response(
                    201,
                    [],
                    '{"id": 2, "test": "2", "remote": "test"}'
                )
            );

        Unit::insert([
            ['test' => 1],
            ['test' => 2],
        ]);

        Event::assertDispatched(QueryExecuted::class, 2);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'POST:unit' &&
                $event->bindings == ['test' => 1];
        });

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'POST:unit' &&
                $event->bindings == ['test' => 2];
        });
    }

    public function test_api_update()
    {
        Event::fake();

        $name = Str::random();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->twice()
            ->andReturn(
                new Response(
                    200,
                    [],
                    '{"result": [{"id": 1}]}'
                ),
                new Response(
                    200,
                    [],
                    '{"result": [{"id": 1, "name": '.$name.'}]}'
                )
            );

        $unit = Unit::find(1);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'GET:unit?id-eq=1&pageSize=1';
        });

        $this->assertTrue($unit->exists);
        $this->assertEquals(1, $unit->id);

        $unit->name = $name;

        $this->assertTrue($unit->isDirty());

        $unit->save();

        Event::assertDispatched(QueryExecuted::class, function ($event) use ($unit) {
            return (string) $event->sql == 'PUT:unit/id/1' &&
                $event->bindings == $unit->getAttributes();
        });

        $this->assertTrue($unit->isClean());
    }

    public function test_api_update_not_supported()
    {
        $this->expectException(NotSupportedException::class);

        Unit::whereNull('this')
            ->update(['this' => 'that']);
    }

    public function test_connection()
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1},{"id": 2}]}'
            ));

        $connection = (new Unit)->getConnection();

        $query = $connection->table('test');

        $this->assertEquals('test', $query->toSql()->getUri()->getPath());

        $request = $connection->getQueryGrammar()->compileSelect($query);

        $unit = $connection->selectOne($request);

        $this->assertArrayHasKey('id', $unit);
    }

    public function test_customer_party_type()
    {
        $customer = new Customer;

        $this->assertEquals('ORGANIZATION', $customer->partyType);
    }

    public function test_pagination()
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(
                new Response(
                    200,
                    [],
                    '{"result": [{"id": 1},{"id": 2}]}'
                ),
                new Response(
                    200,
                    [],
                    '{"result": [{"id": 3},{"id": 4}]}'
                ),
                new Response(
                    200,
                    [],
                    '{"result": [{"id": 5}]}'
                )
            );

        Customer::where('test', 'this')
            ->chunk(2, function ($customers, $page) {
                if ($page < 3) {
                    $this->assertCount(2, $customers);
                } else {
                    $this->assertCount(1, $customers);
                }
            });

        Event::assertDispatched(QueryExecuted::class, 3);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'GET:party?test-eq=this&customer-eq=true&sort=id&page=1&pageSize=2';
        });

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'GET:party?test-eq=this&customer-eq=true&sort=id&page=2&pageSize=2';
        });

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'GET:party?test-eq=this&customer-eq=true&sort=id&page=3&pageSize=2';
        });

        // assert that we returned from the loop
        $this->assertTrue(true);
    }

    public function test_logging()
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1},{"id": 2}]}'
            ));

        app(Connection::class)->enableQueryLog();
        $this->assertTrue(app(Connection::class)->logging());

        $this->assertTrue((new Customer)->getConnection()->logging());

        $this->assertEmpty(app(Connection::class)->getQueryLog());

        Unit::findMany([1, 2]);

        $this->assertNotEmpty(app(Connection::class)->getQueryLog());

        $this->assertEquals('GET:unit?id-in=%5B1,2%5D&pageSize=100', app(Connection::class)->getQueryLog()[0]['query']);

        app(Connection::class)->flushQueryLog();

        $this->assertEmpty(app(Connection::class)->getQueryLog());

        app(Connection::class)->disableQueryLog();

        $this->assertFalse(app(Connection::class)->logging());

        Unit::findMany([1, 2]);

        $this->assertEmpty(app(Connection::class)->getQueryLog());
    }

    // -------------------------------------------------------------------------
    // SubModel hydration
    // -------------------------------------------------------------------------

    public function test_sub_model_list_is_hydrated_on_fetch(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": "1", "orderItems": [{"articleId": "A1", "quantity": "2", "positionNumber": 10}]}]}'
            ));

        $order = SalesOrder::find('1');

        // The attribute is hydrated into SubModel instances
        $this->assertIsArray($order->orderItems);
        $this->assertCount(1, $order->orderItems);
        $this->assertInstanceOf(SalesOrderItem::class, $order->orderItems[0]);
    }

    public function test_sub_model_single_object_is_hydrated_on_fetch(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": "1", "recordAddress": {"city": "Berlin", "countryCode": "DE"}}]}'
            ));

        $order = SalesOrder::find('1');

        $this->assertInstanceOf(RecordAddress::class, $order->recordAddress);
        $this->assertEquals('Berlin', $order->recordAddress->city);
        $this->assertEquals('DE', $order->recordAddress->countryCode);
    }

    public function test_sub_model_null_attribute_stays_null(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": "1"}]}'
            ));

        $order = SalesOrder::find('1');

        $this->assertNull($order->orderItems);
        $this->assertNull($order->recordAddress);
    }

    public function test_sub_model_array_access_backwards_compat(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": "1", "orderItems": [{"articleId": "A1", "quantity": "2"}]}]}'
            ));

        $order = SalesOrder::find('1');

        // Old array-access style still works
        $this->assertEquals('A1', $order->orderItems[0]['articleId']);
        $this->assertEquals('2', $order->orderItems[0]['quantity']);

        // New object-style also works
        $this->assertEquals('A1', $order->orderItems[0]->articleId);
        $this->assertEquals('2', $order->orderItems[0]->quantity);
    }

    public function test_sub_model_serialises_back_to_plain_arrays_on_save(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->twice()
            ->andReturn(
                new Response(200, [], '{"result": [{"id": "1", "orderItems": [{"articleId": "A1", "quantity": "2"}]}]}'),
                new Response(200, [], '{"result": [{"id": "1"}]}')
            );

        $order = SalesOrder::find('1');

        // Dirty the model so save() actually fires a PUT.
        $order->note = 'updated';
        $order->save();

        // PUT bindings must contain plain arrays, not SubModel objects.
        Event::assertDispatched(QueryExecuted::class, function ($event) {
            if ((string) $event->sql !== 'PUT:salesOrder/id/1') {
                return false;
            }
            $items = $event->bindings['orderItems'] ?? null;

            return is_array($items) && isset($items[0]) && is_array($items[0]);
        });
    }

    public function test_sub_model_cast_resolves_correct_class(): void
    {
        $cast = SalesOrderItem::castUsing([]);
        $result = $cast->get(new SalesOrder, 'orderItems', [['articleId' => 'X']], []);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(SalesOrderItem::class, $result[0]);
        $this->assertInstanceOf(SubModel::class, $result[0]);
        $this->assertEquals('X', $result[0]->articleId);
        $this->assertEquals('X', $result[0]['articleId']);
    }

    public function test_sub_model_set_returns_plain_arrays(): void
    {
        $cast = SalesOrderItem::castUsing([]);
        $item = new SalesOrderItem(['articleId' => 'X', 'quantity' => '1']);

        $result = $cast->set(new SalesOrder, 'orderItems', [$item], []);

        $this->assertIsArray($result);
        $this->assertIsArray($result[0]);
        $this->assertEquals('X', $result[0]['articleId']);
    }

    // -------------------------------------------------------------------------
    // Backwards compatibility: SubModel behaves like a plain array
    // -------------------------------------------------------------------------

    /**
     * foreach ($item as $key => $value) must iterate over the attributes,
     * exactly like iterating over the plain array it replaces.
     */
    public function test_sub_model_foreach_iteration(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1', 'quantity' => '2', 'positionNumber' => 10]);

        $collected = [];
        foreach ($item as $key => $value) {
            $collected[$key] = $value;
        }

        $this->assertSame(['articleId' => 'A1', 'quantity' => '2', 'positionNumber' => 10], $collected);
    }

    /**
     * count($item) must return the number of attributes, like count() on
     * the plain array it replaces.
     */
    public function test_sub_model_count(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1', 'quantity' => '2', 'positionNumber' => 10]);

        $this->assertSame(3, count($item));
        $this->assertCount(3, $item);
    }

    /**
     * json_encode($item) must produce the same JSON as encoding the plain array
     * it replaces, not an empty object {}.
     */
    public function test_sub_model_json_encode_single_item(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1', 'quantity' => '2']);

        $this->assertSame(json_encode(['articleId' => 'A1', 'quantity' => '2']), json_encode($item));
    }

    /**
     * json_encode() on the parent model must still produce the same JSON as
     * it would have with plain arrays — Eloquent calls toArray() which
     * flattens SubModel instances via Arrayable.
     */
    public function test_sub_model_json_encode_parent_model(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": "1", "orderItems": [{"articleId": "A1", "quantity": "2"}]}]}'
            ));

        $order = SalesOrder::find('1');

        $decoded = json_decode($order->toJson(), true);

        $this->assertIsArray($decoded['orderItems']);
        $this->assertIsArray($decoded['orderItems'][0]);
        $this->assertEquals('A1', $decoded['orderItems'][0]['articleId']);
    }

    /**
     * $order->toArray() must return a nested plain array, not an array of
     * SubModel objects — existing code that calls toArray() for serialisation
     * must continue to work.
     */
    public function test_sub_model_to_array_on_parent_returns_plain_nested_arrays(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": "1", "orderItems": [{"articleId": "A1"}], "recordAddress": {"city": "Berlin"}}]}'
            ));

        $order = SalesOrder::find('1');
        $arr = $order->toArray();

        // List field: outer list and each item must both be plain arrays
        $this->assertIsArray($arr['orderItems']);
        $this->assertIsArray($arr['orderItems'][0]);
        $this->assertEquals('A1', $arr['orderItems'][0]['articleId']);

        // Single-object field: must also be a plain array
        $this->assertIsArray($arr['recordAddress']);
        $this->assertEquals('Berlin', $arr['recordAddress']['city']);
    }

    /**
     * isset($item['key']) must work for both present and absent attributes.
     */
    public function test_sub_model_isset_on_bracket(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1', 'quantity' => null]);

        $this->assertTrue(isset($item['articleId']));
        $this->assertFalse(isset($item['quantity']));   // null → not set
        $this->assertFalse(isset($item['nonExistent']));
    }

    /**
     * Writing via bracket syntax must persist to the SubModel attributes and
     * round-trip correctly through toArray().
     */
    public function test_sub_model_bracket_write(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1']);
        $item['quantity'] = '5';

        $this->assertEquals('5', $item['quantity']);
        $this->assertEquals('5', $item->quantity);
        $this->assertEquals(['articleId' => 'A1', 'quantity' => '5'], $item->toArray());
    }

    /**
     * unset($item['key']) must remove the attribute.
     */
    public function test_sub_model_bracket_unset(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1', 'quantity' => '2']);
        unset($item['quantity']);

        $this->assertFalse(isset($item['quantity']));
        $this->assertArrayNotHasKey('quantity', $item->toArray());
    }

    /**
     * is_array() on a list field still returns true (the outer list is a
     * native PHP array of SubModel instances, not a SubModel itself).
     */
    public function test_sub_model_list_field_is_still_array(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": "1", "orderItems": [{"articleId": "A1"}]}]}'
            ));

        $order = SalesOrder::find('1');

        // The outer list must still be a plain PHP array
        $this->assertIsArray($order->orderItems);
        // The individual item is a SubModel, not a plain array
        $this->assertInstanceOf(SubModel::class, $order->orderItems[0]);
    }

    /**
     * SubModel implements Countable, IteratorAggregate, and JsonSerializable,
     * so all three interfaces can be type-checked when needed.
     */
    public function test_sub_model_implements_extra_interfaces(): void
    {
        $item = new SalesOrderItem([]);

        $this->assertInstanceOf(\Countable::class, $item);
        $this->assertInstanceOf(\IteratorAggregate::class, $item);
        $this->assertInstanceOf(\JsonSerializable::class, $item);
    }

    /**
     * SubModel::toArray() on the sub-model itself returns the raw attributes.
     */
    public function test_sub_model_to_array_on_sub_model_itself(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1', 'quantity' => '3']);

        $this->assertSame(['articleId' => 'A1', 'quantity' => '3'], $item->toArray());
    }

    // -------------------------------------------------------------------------
    // Relation loading: eager (batch) vs lazy (N+1)
    // -------------------------------------------------------------------------

    /**
     * The base Model must declare $keyType = 'string' so that Eloquent's
     * eager-loader picks whereIn instead of whereIntegerInRaw.
     */
    public function test_model_key_type_is_string(): void
    {
        $this->assertSame('string', (new SalesOrder)->getKeyType());
        $this->assertSame('string', (new Customer)->getKeyType());
        $this->assertSame('string', (new Unit)->getKeyType());
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

    // -------------------------------------------------------------------------
    // Read-only guards ($creatable / $deletable)
    // -------------------------------------------------------------------------

    /**
     * Calling save() on a new WarehouseStock (creatable=false) must throw.
     */
    public function test_non_creatable_model_throws_on_save(): void
    {
        $this->expectException(NotSupportedException::class);

        $stock = new WarehouseStock;
        $stock->save();
    }

    /**
     * Calling delete() on an existing WarehouseStock (deletable=false) must throw.
     */
    public function test_non_deletable_model_throws_on_delete(): void
    {
        $this->expectException(NotSupportedException::class);

        $stock = new WarehouseStock;
        $stock->exists = true;
        $stock->id = '1';
        $stock->delete();
    }

    /**
     * Calling delete() on an existing CashAccount (deletable=false) must throw.
     */
    public function test_cash_account_non_deletable_throws_on_delete(): void
    {
        $this->expectException(NotSupportedException::class);

        $account = new CashAccount;
        $account->exists = true;
        $account->id = '1';
        $account->delete();
    }

    /**
     * CashAccount is creatable (no $creatable=false), so save() on a new
     * instance must NOT throw — it should proceed to the HTTP layer.
     * We mock the Client so it never actually hits the network.
     */
    public function test_creatable_model_does_not_throw_on_save(): void
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(201, [], '{"id": "1"}'));

        $account = new CashAccount;
        $account->save(); // must not throw NotSupportedException

        $this->assertTrue($account->exists);
    }

    /**
     * SalesOrder is both creatable and deletable (defaults), so delete() must
     * NOT throw — the HTTP layer handles it.
     */
    public function test_deletable_model_does_not_throw_on_delete(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(204));

        $order = new SalesOrder;
        $order->exists = true;
        $order->id = '1';
        $order->delete(); // must not throw NotSupportedException

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql === 'DELETE:salesOrder/id/1';
        });
    }

    // -------------------------------------------------------------------------
    // withProperties query builder method
    // -------------------------------------------------------------------------

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

    // -------------------------------------------------------------------------
    // action (collection-level) and callAction (instance-level)
    // -------------------------------------------------------------------------

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

    // -------------------------------------------------------------------------
    // belongsTo relations
    // -------------------------------------------------------------------------

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

    // -------------------------------------------------------------------------
    // hasMany relations
    // -------------------------------------------------------------------------

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

    // -------------------------------------------------------------------------
    // Boolean grammar serialization
    // -------------------------------------------------------------------------

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

    // -------------------------------------------------------------------------
    // Party-type global scopes
    // -------------------------------------------------------------------------

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

    // -------------------------------------------------------------------------
    // SystemApi
    // -------------------------------------------------------------------------

    /**
     * SystemApi::permissions() must issue GET:system/permissions and return the result array.
     */
    public function test_system_api_permissions_returns_array(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], '{"result": ["party:read", "salesOrder:read"]}'));

        $api = app(SystemApi::class);
        $result = $api->permissions();

        $this->assertSame(['party:read', 'salesOrder:read'], $result);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql === 'GET:system/permissions';
        });
    }

    /**
     * SystemApi::permissions() returns an empty array when the result is empty/null.
     */
    public function test_system_api_permissions_returns_empty_array_on_null(): void
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], '{"result": []}'));

        $result = app(SystemApi::class)->permissions();

        $this->assertSame([], $result);
    }

    /**
     * SystemApi::licenses() must issue GET:system/licenses and return the result array.
     */
    public function test_system_api_licenses_returns_array(): void
    {
        Event::fake();

        $licenses = [
            ['name' => 'SALES', 'permissions' => ['salesOrder:read', 'salesOrder:write']],
        ];

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], json_encode(['result' => $licenses])));

        $result = app(SystemApi::class)->licenses();

        $this->assertSame($licenses, $result);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql === 'GET:system/licenses';
        });
    }

    /**
     * SystemApi::demoTestSystemInfo() must issue GET:system/demoTestSystemInfo
     * and return the unwrapped 'result' value.
     */
    public function test_system_api_demo_test_system_info_returns_result(): void
    {
        Event::fake();

        $info = ['createPossible' => true, 'creationInProgress' => false, 'demoInstanceUrl' => null, 'mainInstanceUrl' => null];

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], json_encode(['result' => $info])));

        $result = app(SystemApi::class)->demoTestSystemInfo();

        $this->assertSame($info, $result);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql === 'GET:system/demoTestSystemInfo';
        });
    }

    /**
     * SystemApi::createDemoTestSystem() must issue POST:system/createDemoTestSystem.
     */
    public function test_system_api_create_demo_test_system_posts_correct_url(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], '{"result": {"result": "SUCCESS"}}'));

        app(SystemApi::class)->createDemoTestSystem('My Test', 'PROD_SYSTEM');

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql === 'POST:system/createDemoTestSystem';
        });
    }

    // -------------------------------------------------------------------------
    // JobApi
    // -------------------------------------------------------------------------

    /**
     * JobApi::status() must issue GET:job/status?type=INVENTORY_BOOKING and return result.
     */
    public function test_job_api_status_dispatches_correct_url(): void
    {
        Event::fake();

        $jobResult = ['type' => 'INVENTORY_BOOKING', 'status' => 'EXECUTING', 'progress' => ['current' => 42, 'total' => 100]];

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], json_encode(['result' => $jobResult])));

        $result = app(JobApi::class)->status('INVENTORY_BOOKING');

        $this->assertSame($jobResult, $result);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql === 'GET:job/status?type=INVENTORY_BOOKING';
        });
    }

    /**
     * JobApi::abort() must issue GET:job/abort?type=INVENTORY_BOOKING and return result.
     */
    public function test_job_api_abort_dispatches_correct_url(): void
    {
        Event::fake();

        $jobResult = ['type' => 'INVENTORY_BOOKING', 'status' => 'ABORTING', 'progress' => null];

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], json_encode(['result' => $jobResult])));

        $result = app(JobApi::class)->abort('INVENTORY_BOOKING');

        $this->assertSame($jobResult, $result);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql === 'GET:job/abort?type=INVENTORY_BOOKING';
        });
    }
}
