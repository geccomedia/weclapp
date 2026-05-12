<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\SalesInvoice;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class SalesInvoiceTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_cost_center_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesInvoice)->costCenter());
    }

    public function test_cost_type_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesInvoice)->costType());
    }

    public function test_creator_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesInvoice)->creator());
    }

    public function test_customer_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesInvoice)->customer());
    }

    public function test_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesInvoice)->nonStandardTax());
    }

    public function test_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesInvoice)->paymentMethod());
    }

    public function test_preceding_sales_invoice_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesInvoice)->precedingSalesInvoice());
    }

    public function test_quotation_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesInvoice)->quotation());
    }

    public function test_record_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesInvoice)->recordCurrency());
    }

    public function test_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesInvoice)->responsibleUser());
    }

    public function test_sales_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesInvoice)->salesOrder());
    }

    public function test_sepa_direct_debit_mandate_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesInvoice)->sepaDirectDebitMandate());
    }

    public function test_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesInvoice)->shipmentMethod());
    }

    public function test_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesInvoice)->termOfPayment());
    }

    public function test_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesInvoice)->currency());
    }
}
