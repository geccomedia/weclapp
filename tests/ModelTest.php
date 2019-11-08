<?php namespace Geccomedia\Weclapp\Tests;

use Geccomedia\Weclapp\Models\Customer;
use Geccomedia\Weclapp\Models\SalesInvoice;
use Geccomedia\Weclapp\Models\Unit;
use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\NotSupportedException;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

class ModelFunctionTest extends TestCase
{
    /**
     * @var Model
     */
    private $model;

    public function setUp(): void
    {
        $this->model = $this->getMockForAbstractClass('Geccomedia\Weclapp\Model');
        parent::setUp();
    }

    public function testDateFormatOnBaseModel()
    {
        $this->assertTrue($this->model->getDateFormat() == 'U');
    }

    public function testCreatedAtConst()
    {
        $this->assertTrue(Model::CREATED_AT == 'createdDate');
    }

    public function testUpdatedAtConst()
    {
        $this->assertTrue(Model::UPDATED_AT == 'lastModifiedDate');
    }

    public function testDateConversion()
    {
        Event::fake();

        $now = now();

        $this->assertEquals($now->timestamp * 1000, $this->model->fromDateTime($now));

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1, "invoiceDate": '.($now->timestamp * 1000).'}]}'
            ));

        $invoice = SalesInvoice::find(1);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql->getUri() == 'salesInvoice?id-eq=1&pageSize=1' &&
                $event->sql->getMethod() == 'GET';
        });

        $this->assertEquals($now->timestamp, $invoice->invoiceDate->timestamp);
    }

    public function testApiGet()
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
            return (string) $event->sql->getUri() == 'unit?2-eq=3&properties=1&sort=-4&page=1&pageSize=5' &&
                $event->sql->getMethod() == 'GET';
        });

        $this->assertEquals(2, $units->count());

        $this->assertEquals(1, $units->first()->id);
    }

    public function testNotFound()
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(404));

        $unit = Unit::find(1);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql->getUri() == 'unit?id-eq=1&pageSize=1' &&
                $event->sql->getMethod() == 'GET';
        });

        $this->assertNull($unit);
    }

    public function testApiGetAll()
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
            return (string) $event->sql->getUri() == 'unit?test-notin=%5B1,2%5D&test2-null=&test3-notnull=&pageSize=100' &&
                $event->sql->getMethod() == 'GET';
        });

        $this->assertEquals(2, $units->count());
    }

    public function testApiCount()
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
            return (string) $event->sql->getUri() == 'unit/count?1-eq=2&pageSize=100' &&
                $event->sql->getMethod() == 'GET';
        });

        $this->assertEquals(55, $count);
    }

    public function testFindMany()
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
            return (string) $event->sql->getUri() == 'unit?id-in=%5B1,2%5D&pageSize=100' &&
                $event->sql->getMethod() == 'GET';
        });

        $this->assertEquals(2, $units->count());

        $this->assertEquals(1, $units->first()->id);
    }

    public function testApiDelete()
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(204));

        $deleted = Unit::whereKey(1)
            ->delete();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql->getUri() == 'unit/id/1' &&
                $event->sql->getMethod() == 'DELETE';
        });

        $this->assertTrue($deleted);

        $this->expectException(NotSupportedException::class);

        Unit::where('this', 'that')
            ->delete();
    }

    public function testApiInsert()
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(new Response(
                201,
                [],
                '{"id": 1, "test": "bla", "remote": "test"}'
            ));

        $unit = new Unit();
        $unit->test = 'bla';
        $unit->save();

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql->getUri() == 'unit' &&
                $event->sql->getMethod() == 'POST' &&
                $event->sql->getBody()->getContents() == '{"test":"bla"}';
        });

        $this->assertTrue($unit->exists);
        $this->assertEquals(1, $unit->id);
        $this->assertEquals('bla', $unit->test);
        $this->assertEquals('test', $unit->remote);

        Unit::insert(['test' => 1]);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            $event->sql->getBody()->rewind();
            return (string) $event->sql->getUri() == 'unit' &&
                $event->sql->getMethod() == 'POST' &&
                $event->sql->getBody()->getContents() == '{"test":1}';
        });
    }

    public function testApiMultiInsert()
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
            $event->sql->getBody()->rewind();
            return (string) $event->sql->getUri() == 'unit' &&
                $event->sql->getMethod() == 'POST' &&
                $event->sql->getBody()->getContents() == '{"test":1}';
        });

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            $event->sql->getBody()->rewind();
            return (string) $event->sql->getUri() == 'unit' &&
                $event->sql->getMethod() == 'POST' &&
                $event->sql->getBody()->getContents() == '{"test":2}';
        });
    }

    public function testApiUpdate()
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1}]}'
            ));

        $unit = Unit::find(1);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql->getUri() == 'unit?id-eq=1&pageSize=1' &&
                $event->sql->getMethod() == 'GET';
        });

        $this->assertTrue($unit->exists);
        $this->assertEquals(1, $unit->id);

        $unit->name = Str::random();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1, "name": ' . $unit->name . '}]}'
            ));

        $this->assertTrue($unit->isDirty());

        $unit->save();

        Event::assertDispatched(QueryExecuted::class, function ($event) use ($unit) {
            $event->sql->getBody()->rewind();
            return (string) $event->sql->getUri() == 'unit/id/1' &&
                $event->sql->getMethod() == 'PUT' &&
                $event->sql->getBody()->getContents() == json_encode($unit->getAttributes());
        });

        $this->assertTrue($unit->isClean());
    }

    public function testApiUpdateNotSupported()
    {
        $this->expectException(NotSupportedException::class);

        Unit::whereNull('this')
            ->update(['this' => 'that']);
    }

    public function testConnection()
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

    public function testCustomerPartyType()
    {
        $customer = new Customer();

        $this->assertEquals('ORGANIZATION', $customer->partyType);
    }

    public function testPagination()
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
            ->chunk(2, function($customers, $page){
                if($page < 3){
                    $this->assertCount(2, $customers);
                }
                else{
                    $this->assertCount(1, $customers);
                }
            });

        Event::assertDispatched(QueryExecuted::class, 3);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql->getUri() == 'customer?test-eq=this&sort=id&page=1&pageSize=2' &&
                $event->sql->getMethod() == 'GET';
        });

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql->getUri() == 'customer?test-eq=this&sort=id&page=2&pageSize=2' &&
                $event->sql->getMethod() == 'GET';
        });

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql->getUri() == 'customer?test-eq=this&sort=id&page=3&pageSize=2' &&
                $event->sql->getMethod() == 'GET';
        });

        // assert that we returned from the loop
        $this->assertTrue(true);
    }
}