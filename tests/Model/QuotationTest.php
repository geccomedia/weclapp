<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Quotation;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class QuotationTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_creator_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->creator());
    }

    public function test_customer_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->customer());
    }

    public function test_default_shipping_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->defaultShippingCarrier());
    }

    public function test_invoice_recipient_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->invoiceRecipient());
    }

    public function test_merged_to_quotation_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->mergedToQuotation());
    }

    public function test_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->nonStandardTax());
    }

    public function test_opportunity_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->opportunity());
    }

    public function test_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->paymentMethod());
    }

    public function test_record_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->recordCurrency());
    }

    public function test_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->responsibleUser());
    }

    public function test_sales_stage_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->salesStage());
    }

    public function test_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->shipmentMethod());
    }

    public function test_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->termOfPayment());
    }

    public function test_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->warehouse());
    }

    public function test_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->currency());
    }

    public function test_task_template_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Quotation)->taskTemplate());
    }
}
