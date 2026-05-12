<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\SalesOrder;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class SalesOrderRelationsTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_cash_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->cashAccount());
    }

    public function test_creator_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->creator());
    }

    public function test_customer_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->customer());
    }

    public function test_default_shipping_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->defaultShippingCarrier());
    }

    public function test_default_shipping_return_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->defaultShippingReturnCarrier());
    }

    public function test_fulfillment_provider_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->fulfillmentProvider());
    }

    public function test_invoice_recipient_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->invoiceRecipient());
    }

    public function test_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->nonStandardTax());
    }

    public function test_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->paymentMethod());
    }

    public function test_quotation_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->quotation());
    }

    public function test_record_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->recordCurrency());
    }

    public function test_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->responsibleUser());
    }

    public function test_sepa_direct_debit_mandate_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->sepaDirectDebitMandate());
    }

    public function test_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->shipmentMethod());
    }

    public function test_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->termOfPayment());
    }

    public function test_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->warehouse());
    }

    public function test_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOrder)->currency());
    }

    public function test_shipments_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new SalesOrder)->shipments());
    }

    public function test_sales_invoices_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new SalesOrder)->salesInvoices());
    }
}
