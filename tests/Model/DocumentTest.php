<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Document;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class DocumentTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    private function documentInstance(): Document
    {
        $model = new Document;
        $model->exists = true;
        $model->id = '1';

        return $model;
    }

    // -------------------------------------------------------------------------
    // Document relation
    // -------------------------------------------------------------------------

    public function test_document_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Document)->user());
    }

    // -------------------------------------------------------------------------
    // Document actions (instance-level POST)
    // -------------------------------------------------------------------------

    public function test_document_copy_post_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->documentInstance()->copy();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:document/id/1/copy'));
    }

    public function test_document_upload_post_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->documentInstance()->upload();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:document/id/1/upload'));
    }

    // -------------------------------------------------------------------------
    // Document actions (instance-level GET)
    // -------------------------------------------------------------------------

    public function test_document_download_get_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->documentInstance()->download();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:document/id/1/download'));
    }

    public function test_document_download_document_version_get_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->documentInstance()->downloadDocumentVersion();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:document/id/1/downloadDocumentVersion'));
    }

    public function test_document_download_document_versions_zipped_get_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->documentInstance()->downloadDocumentVersionsZipped();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:document/id/1/downloadDocumentVersionsZipped'));
    }
}
