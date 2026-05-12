<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\InternalTransportReference;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class InternalTransportReferenceTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_internal_transport_reference_loading_equipment_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class,
            (new InternalTransportReference)->loadingEquipmentArticle());
    }

    public function test_internal_transport_reference_loading_equipment_identifier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class,
            (new InternalTransportReference)->loadingEquipmentIdentifier());
    }

    public function test_internal_transport_reference_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class,
            (new InternalTransportReference)->warehouse());
    }
}
