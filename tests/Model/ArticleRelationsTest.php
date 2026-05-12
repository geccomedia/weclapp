<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Article;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ArticleRelationsTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    // ── BelongsTo ─────────────────────────────────────────────────────────────

    public function test_article_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->account());
    }

    public function test_article_article_category_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->articleCategory());
    }

    public function test_article_customs_tariff_number_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->customsTariffNumber());
    }

    public function test_article_default_loading_equipment_identifier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->defaultLoadingEquipmentIdentifier());
    }

    public function test_article_expense_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->expenseAccount());
    }

    public function test_article_loading_equipment_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->loadingEquipmentArticle());
    }

    public function test_article_manufacturer_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->manufacturer());
    }

    public function test_article_packaging_unit_base_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->packagingUnitBaseArticle());
    }

    public function test_article_packaging_unit_parent_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->packagingUnitParentArticle());
    }

    public function test_article_primary_supply_source_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->primarySupplySource());
    }

    public function test_article_purchase_cost_center_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->purchaseCostCenter());
    }

    public function test_article_sales_cost_center_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->salesCostCenter());
    }

    public function test_article_service_article_for_service_quota_booking_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->serviceArticleForServiceQuotaBooking());
    }

    public function test_article_unit_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->unit());
    }

    public function test_article_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->tax());
    }

    public function test_article_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->warehouse());
    }

    public function test_article_rating_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->rating());
    }

    public function test_article_status_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Article)->status());
    }

    // ── HasMany ───────────────────────────────────────────────────────────────

    public function test_article_article_prices_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Article)->articlePrices());
    }

    public function test_article_article_supply_sources_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Article)->articleSupplySources());
    }

    public function test_article_batch_numbers_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Article)->batchNumbers());
    }

    public function test_article_serial_numbers_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Article)->serialNumbers());
    }

    public function test_article_warehouse_stock_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Article)->warehouseStock());
    }
}
