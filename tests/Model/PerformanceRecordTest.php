<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\PerformanceRecord;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class PerformanceRecordTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    public function test_creator_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PerformanceRecord)->creator());
    }

    public function test_customer_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PerformanceRecord)->customer());
    }

    public function test_invoice_recipient_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PerformanceRecord)->invoiceRecipient());
    }

    public function test_sales_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PerformanceRecord)->salesOrder());
    }

    public function test_service_provider_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PerformanceRecord)->serviceProvider());
    }

    // -------------------------------------------------------------------------
    // Actions  (instance: /performanceRecord/id/{id}/…)
    // -------------------------------------------------------------------------

    public function test_add_to_performance_record_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new PerformanceRecord;
        $model->exists = true;
        $model->id = '1';
        $model->addToPerformanceRecord();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:performanceRecord/id/1/addToPerformanceRecord')
        );
    }

    public function test_create_invoice_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new PerformanceRecord;
        $model->exists = true;
        $model->id = '1';
        $model->createInvoice();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:performanceRecord/id/1/createInvoice')
        );
    }

    public function test_download_latest_performance_record_pdf_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new PerformanceRecord;
        $model->exists = true;
        $model->id = '1';
        $model->downloadLatestPerformanceRecordPdf();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:performanceRecord/id/1/downloadLatestPerformanceRecordPdf')
        );
    }

    public function test_download_signature_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new PerformanceRecord;
        $model->exists = true;
        $model->id = '1';
        $model->downloadSignature();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:performanceRecord/id/1/downloadSignature')
        );
    }

    public function test_perform_service_quota_assignment_for_time_records_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new PerformanceRecord;
        $model->exists = true;
        $model->id = '1';
        $model->performServiceQuotaAssignmentForTimeRecords();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:performanceRecord/id/1/performServiceQuotaAssignmentForTimeRecords')
        );
    }

    public function test_recalculate_quantities_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new PerformanceRecord;
        $model->exists = true;
        $model->id = '1';
        $model->recalculateQuantities();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:performanceRecord/id/1/recalculateQuantities')
        );
    }

    public function test_remove_signature_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new PerformanceRecord;
        $model->exists = true;
        $model->id = '1';
        $model->removeSignature();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:performanceRecord/id/1/removeSignature')
        );
    }

    public function test_upload_signature_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new PerformanceRecord;
        $model->exists = true;
        $model->id = '1';
        $model->uploadSignature();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:performanceRecord/id/1/uploadSignature')
        );
    }

    public function test_start_configured_mass_performance_record_creation_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new PerformanceRecord;
        $model->exists = true;
        $model->id = '1';
        $model->startConfiguredMassPerformanceRecordCreation();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:performanceRecord/id/1/startConfiguredMassPerformanceRecordCreation')
        );
    }
}
