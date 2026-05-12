<?php

namespace Geccomedia\Weclapp\Tests;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\ServiceProvider;
use Geccomedia\Weclapp\SystemApi;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class SystemApiTest extends OrchestraTestCase
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
}
