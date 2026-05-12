<?php

namespace Geccomedia\Weclapp\Tests\Concerns;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Model;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;

/**
 * Helpers for tests that talk to the Weclapp HTTP client.
 *
 * Provides:
 *   mockClient()           — mock Client::send() once, returning HTTP 200 with an empty JSON object.
 *   mockClientWith(...)    — mock Client::send() once, returning the given Response.
 *   makeInstance($class)   — instantiate a persisted model stub (exists=true, id='1').
 *   assertSql($fragment)   — assert that a QueryExecuted event whose sql contains $fragment was fired.
 */
trait MocksClient
{
    /**
     * Mock the Weclapp HTTP client to return a single empty-object 200 response.
     * Covers the common case used in action-dispatch tests.
     */
    protected function mockClient(): void
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], '{}'));
    }

    /**
     * Mock the Weclapp HTTP client to return exactly the given response once.
     */
    protected function mockClientWith(Response $response): void
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn($response);
    }

    /**
     * Return a new persisted model stub of the given class.
     * Sets exists=true and id='1' so instance-level action methods route
     * to the /id/1/action endpoint.
     *
     * @template T of Model
     *
     * @param  class-string<T>  $class
     * @return T
     */
    protected function makeInstance(string $class): Model
    {
        /** @var T $model */
        $model = new $class;
        $model->exists = true;
        $model->id = '1';

        return $model;
    }

    /**
     * Assert that a QueryExecuted event was dispatched whose sql contains
     * the given substring. Call Event::fake() before the action under test.
     */
    protected function assertSql(string $fragment): void
    {
        Event::assertDispatched(
            QueryExecuted::class,
            fn ($e) => str_contains((string) $e->sql, $fragment),
        );
    }
}
