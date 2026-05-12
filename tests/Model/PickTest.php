<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Pick;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class PickTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_pick_confirmed_by_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Pick)->confirmedByUser());
    }

    public function test_pick_internal_transport_reference_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Pick)->internalTransportReference());
    }

    public function test_pick_packaging_unit_base_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Pick)->packagingUnitBaseArticle());
    }

    public function test_pick_source_internal_transport_reference_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Pick)->sourceInternalTransportReference());
    }

    public function test_pick_source_storage_place_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Pick)->sourceStoragePlace());
    }

    public function test_pick_storage_place_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Pick)->storagePlace());
    }

    public function test_pick_transportation_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Pick)->transportationOrder());
    }
}
