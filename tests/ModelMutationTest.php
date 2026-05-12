<?php

namespace Geccomedia\Weclapp\Tests;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\Unit;
use Geccomedia\Weclapp\NotSupportedException;
use Geccomedia\Weclapp\ServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ModelMutationTest extends OrchestraTestCase
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
}
