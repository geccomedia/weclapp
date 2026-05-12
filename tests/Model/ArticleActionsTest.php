<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Article;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ArticleActionsTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    public function test_article_change_unit_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(Article::class)->changeUnit(['unitId' => '42']);
        $this->assertSql('POST:article/id/1/changeUnit');
    }

    public function test_article_create_datasheet_pdf_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(Article::class)->createDatasheetPdf();
        $this->assertSql('POST:article/id/1/createDatasheetPdf');
    }

    public function test_article_create_label_pdf_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(Article::class)->createLabelPdf();
        $this->assertSql('POST:article/id/1/createLabelPdf');
    }

    public function test_article_download_article_image_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(Article::class)->downloadArticleImage();
        $this->assertSql('GET:article/id/1/downloadArticleImage');
    }

    public function test_article_download_main_article_image_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(Article::class)->downloadMainArticleImage();
        $this->assertSql('GET:article/id/1/downloadMainArticleImage');
    }

    public function test_article_packaging_unit_structure_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(Article::class)->packagingUnitStructure();
        $this->assertSql('GET:article/id/1/packagingUnitStructure');
    }

    public function test_article_upload_article_image_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInstance(Article::class)->uploadArticleImage();
        $this->assertSql('POST:article/id/1/uploadArticleImage');
    }
}
