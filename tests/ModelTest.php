<?php

namespace Geccomedia\Weclapp\Tests;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Connection;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\Models\Comment;
use Geccomedia\Weclapp\Models\Customer;
use Geccomedia\Weclapp\Models\SalesInvoice;
use Geccomedia\Weclapp\Models\SalesOrder;
use Geccomedia\Weclapp\Models\Unit;
use Geccomedia\Weclapp\NotSupportedException;
use Geccomedia\Weclapp\ServiceProvider;
use Geccomedia\Weclapp\SubModel;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Geccomedia\Weclapp\SubModels\SalesOrderItem;
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
            return (string) $event->sql == 'GET:customer?test-eq=this&sort=id&page=1&pageSize=2';
        });

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'GET:customer?test-eq=this&sort=id&page=2&pageSize=2';
        });

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'GET:customer?test-eq=this&sort=id&page=3&pageSize=2';
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
}
