<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\ExternalConnection;
use Geccomedia\Weclapp\Models\RemotePrintJob;
use Geccomedia\Weclapp\Models\TaskTemplate;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class RemainingTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // -------------------------------------------------------------------------
    // RemotePrintJob – relations
    // -------------------------------------------------------------------------

    public function test_remote_print_job_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new RemotePrintJob)->user());
    }

    public function test_remote_print_job_weclapp_os_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new RemotePrintJob)->weclappOs());
    }

    public function test_remote_print_job_document_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new RemotePrintJob)->document());
    }

    // -------------------------------------------------------------------------
    // RemotePrintJob – instance-level POST action (exists=true)
    // -------------------------------------------------------------------------

    public function test_remote_print_job_create_print_job_with_document_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new RemotePrintJob;
        $model->exists = true;
        $model->id = '1';
        $model->createPrintJobWithDocument();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:remotePrintJob/id/1/createPrintJobWithDocument'));
    }

    // -------------------------------------------------------------------------
    // TaskTemplate – relations
    // -------------------------------------------------------------------------

    public function test_task_template_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TaskTemplate)->article());
    }

    public function test_task_template_creator_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TaskTemplate)->creatorUser());
    }

    public function test_task_template_parent_task_template_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TaskTemplate)->parentTaskTemplate());
    }

    // -------------------------------------------------------------------------
    // ExternalConnection – instance-level POST actions (exists=true)
    // -------------------------------------------------------------------------

    public function test_external_connection_start_article_synchronization_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new ExternalConnection;
        $model->exists = true;
        $model->id = '1';
        $model->startArticleSynchronization();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:externalConnection/id/1/startArticleSynchronization'));
    }

    public function test_external_connection_start_ebay_listing_synchronization_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new ExternalConnection;
        $model->exists = true;
        $model->id = '1';
        $model->startEbayListingSynchronization();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:externalConnection/id/1/startEbayListingSynchronization'));
    }

    public function test_external_connection_start_order_synchronization_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new ExternalConnection;
        $model->exists = true;
        $model->id = '1';
        $model->startOrderSynchronization();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:externalConnection/id/1/startOrderSynchronization'));
    }
}
