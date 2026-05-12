<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\ArticlePrice;
use Geccomedia\Weclapp\Models\ArticleSupplySource;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ArticleTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    // -------------------------------------------------------------------------
    // ArticlePrice relations
    // -------------------------------------------------------------------------

    public function test_article_price_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ArticlePrice)->article());
    }

    public function test_article_price_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ArticlePrice)->currency());
    }

    public function test_article_price_customer_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ArticlePrice)->customer());
    }

    public function test_article_price_last_modified_by_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ArticlePrice)->lastModifiedByUser());
    }

    // -------------------------------------------------------------------------
    // ArticleSupplySource relations
    // -------------------------------------------------------------------------

    public function test_article_supply_source_supplier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ArticleSupplySource)->supplier());
    }

    public function test_article_supply_source_unit_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ArticleSupplySource)->unit());
    }

    public function test_article_supply_source_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ArticleSupplySource)->article());
    }

    public function test_article_supply_source_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ArticleSupplySource)->currency());
    }
}
