<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\ProductionOrder;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ProductionOrderTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_production_order_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ProductionOrder)->article());
    }

    public function test_production_order_assembly_storage_place_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ProductionOrder)->assemblyStoragePlace());
    }

    public function test_production_order_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ProductionOrder)->warehouse());
    }
}
