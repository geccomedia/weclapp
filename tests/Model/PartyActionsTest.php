<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\Party;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Covers the five action methods declared on Party.
 * All are instance-level endpoints: /party/id/{id}/actionName
 */
class PartyActionsTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    public function test_create_public_page_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new Party;
        $model->exists = true;
        $model->id = '1';
        $model->createPublicPage();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:party/id/1/createPublicPage')
        );
    }

    public function test_download_image_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new Party;
        $model->exists = true;
        $model->id = '2';
        $model->downloadImage();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:party/id/2/downloadImage')
        );
    }

    public function test_start_transfer_addresses_to_open_records_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new Party;
        $model->exists = true;
        $model->id = '3';
        $model->startTransferAddressesToOpenRecords();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:party/id/3/startTransferAddressesToOpenRecords')
        );
    }

    public function test_start_transfer_email_addresses_to_open_records_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new Party;
        $model->exists = true;
        $model->id = '4';
        $model->startTransferEmailAddressesToOpenRecords();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:party/id/4/startTransferEmailAddressesToOpenRecords')
        );
    }

    public function test_upload_image_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new Party;
        $model->exists = true;
        $model->id = '5';
        $model->uploadImage();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:party/id/5/uploadImage')
        );
    }
}
