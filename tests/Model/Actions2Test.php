<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\ArticleCategory;
use Geccomedia\Weclapp\Models\User;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class Actions2Test extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // ── ArticleCategory ──────────────────────────────────────────────────────

    public function test_article_category_download_image_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new ArticleCategory)->downloadImage();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:articleCategory/downloadImage'));
    }

    public function test_article_category_upload_image_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new ArticleCategory)->uploadImage();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:articleCategory/uploadImage'));
    }

    // ── User ─────────────────────────────────────────────────────────────────

    public function test_user_delete_mfa_device_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new User)->deleteMfaDevice();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:user/deleteMfaDevice'));
    }

    public function test_user_invite_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new User)->invite();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:user/invite'));
    }

    public function test_user_read_mfa_devices_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new User)->readMfaDevices();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:user/readMfaDevices'));
    }

    public function test_user_soft_delete_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new User)->softDelete();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:user/softDelete'));
    }

    public function test_user_user_image_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new User)->userImage();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:user/userImage'));
    }

    public function test_user_user_image_thumbnail_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new User)->userImageThumbnail();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:user/userImageThumbnail'));
    }

    public function test_user_current_user_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new User)->currentUser();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:user/currentUser'));
    }
}
