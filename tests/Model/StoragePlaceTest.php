<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\StoragePlace;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class StoragePlaceTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_storage_place_current_inventory_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new StoragePlace)->currentInventory());
    }

    public function test_storage_place_customer_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new StoragePlace)->customer());
    }

    public function test_storage_place_shelf_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new StoragePlace)->shelf());
    }

    public function test_storage_place_shelf_storage_location_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new StoragePlace)->shelfStorageLocation());
    }

    public function test_storage_place_storage_location_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new StoragePlace)->storageLocation());
    }

    public function test_storage_place_storage_place_size_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new StoragePlace)->storagePlaceSize());
    }

    public function test_storage_place_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new StoragePlace)->warehouse());
    }
}
