<?php

namespace Geccomedia\Weclapp\Tests;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\JobApi;
use Geccomedia\Weclapp\ServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class JobApiTest extends OrchestraTestCase
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
