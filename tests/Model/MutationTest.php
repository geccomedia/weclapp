<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Connection;
use Geccomedia\Weclapp\Models\Unit;
use Geccomedia\Weclapp\NotSupportedException;
use Geccomedia\Weclapp\Query\Builder;
use Geccomedia\Weclapp\Query\Grammars\Grammar;
use Geccomedia\Weclapp\Query\Processors\Processor;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class MutationTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

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

        $this->assertEquals(1, $deleted);

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

    public function test_api_update_not_supported(): void
    {
        $this->expectException(NotSupportedException::class);

        Unit::whereNull('this')
            ->update(['this' => 'that']);
    }

    public function test_delete_with_id_parameter_issues_correct_request(): void
    {
        // Builder::delete($id) must add a where clause for `table.id` before
        // delegating to the connection. Verify this by confirming the where is
        // present (the grammar then throws because the column is qualified, but
        // that is independent of the branch under test).
        $builder = new Builder(app(Connection::class), new Grammar, new Processor);
        $builder->from('unit');

        // Capture the state *before* deletion reaches the grammar by catching
        // the expected NotSupportedException from buildDeleteRequest.
        try {
            $builder->delete(42);
        } catch (NotSupportedException $e) {
            // The where clause must have been added before the grammar was called.
            $this->assertNotEmpty($builder->wheres);
            $this->assertSame('unit.id', $builder->wheres[0]['column']);
            $this->assertSame(42, $builder->wheres[0]['value']);

            return;
        }

        $this->fail('Expected NotSupportedException was not thrown.');
    }

    public function test_process_insert_get_id_returns_null_when_sql_is_not_a_request(): void
    {
        // The Processor returns null when $sql is not a GuzzleHttp\Psr7\Request
        // instance, exercising the fallback branch on line 28 of Processor.php.
        $processor = new Processor;
        $builder = new Builder(app(Connection::class), new Grammar, $processor);

        $result = $processor->processInsertGetId($builder, 'not-a-request', [], null);

        $this->assertNull($result);
    }
}
