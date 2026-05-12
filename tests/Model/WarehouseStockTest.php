<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\WarehouseStock;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class WarehouseStockTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_warehouse_stock_batch_number_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new WarehouseStock)->batchNumber());
    }

    public function test_warehouse_stock_internal_transport_reference_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new WarehouseStock)->internalTransportReference());
    }

    public function test_warehouse_stock_storage_place_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new WarehouseStock)->storagePlace());
    }

    public function test_warehouse_stock_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new WarehouseStock)->warehouse());
    }

    public function test_warehouse_stock_warehouse_level_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new WarehouseStock)->warehouseLevel());
    }
}
