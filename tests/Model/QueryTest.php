<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Connection;
use Geccomedia\Weclapp\Models\Comment;
use Geccomedia\Weclapp\Models\Customer;
use Geccomedia\Weclapp\Models\Unit;
use Geccomedia\Weclapp\NotSupportedException;
use Geccomedia\Weclapp\Query\Grammars\Grammar;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class QueryTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

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

        /** @var Grammar $grammar */
        $grammar = $connection->getQueryGrammar();
        $request = $grammar->buildSelectRequest($query);

        $this->assertEquals('test', $request->getUri()->getPath());

        $results = $connection->selectRequest($request);
        $unit = $results[0] ?? null;

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
}
