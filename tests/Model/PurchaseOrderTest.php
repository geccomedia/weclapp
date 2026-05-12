<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\PurchaseOrder;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class PurchaseOrderTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_creator_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrder)->creator());
    }

    public function test_merged_to_purchase_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrder)->mergedToPurchaseOrder());
    }

    public function test_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrder)->nonStandardTax());
    }

    public function test_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrder)->paymentMethod());
    }

    public function test_purchase_order_request_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrder)->purchaseOrderRequest());
    }

    public function test_record_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrder)->recordCurrency());
    }

    public function test_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrder)->responsibleUser());
    }

    public function test_sales_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrder)->salesOrder());
    }

    public function test_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrder)->shipmentMethod());
    }

    public function test_shipping_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrder)->shippingCarrier());
    }

    public function test_supplier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrder)->supplier());
    }

    public function test_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrder)->termOfPayment());
    }

    public function test_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrder)->warehouse());
    }

    public function test_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOrder)->currency());
    }
}
