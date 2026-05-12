<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Lead;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Covers the 27 shared BelongsTo methods that Lead re-declares from Party.
 * (The 5 Lead-only extras live in ModelCoverageContactLeadTest.)
 */
class LeadRelationsTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_lead_commercial_language_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->commercialLanguage());
    }

    public function test_lead_company_size_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->companySize());
    }

    public function test_lead_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->currency());
    }

    public function test_lead_customer_category_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->customerCategory());
    }

    public function test_lead_customer_current_sales_stage_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->customerCurrentSalesStage());
    }

    public function test_lead_customer_debtor_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->customerDebtorAccount());
    }

    public function test_lead_customer_default_shipping_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->customerDefaultShippingCarrier());
    }

    public function test_lead_customer_default_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->customerDefaultWarehouse());
    }

    public function test_lead_customer_loss_reason_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->customerLossReason());
    }

    public function test_lead_customer_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->customerNonStandardTax());
    }

    public function test_lead_customer_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->customerPaymentMethod());
    }

    public function test_lead_customer_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->customerShipmentMethod());
    }

    public function test_lead_customer_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->customerTermOfPayment());
    }

    public function test_lead_invoice_recipient_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->invoiceRecipient());
    }

    public function test_lead_lead_source_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->leadSource());
    }

    public function test_lead_parent_party_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->parentParty());
    }

    public function test_lead_primary_contact_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->primaryContact());
    }

    public function test_lead_region_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->region());
    }

    public function test_lead_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->responsibleUser());
    }

    public function test_lead_sector_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->sector());
    }

    public function test_lead_supplier_creditor_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->supplierCreditorAccount());
    }

    public function test_lead_supplier_default_shipping_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->supplierDefaultShippingCarrier());
    }

    public function test_lead_supplier_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->supplierNonStandardTax());
    }

    public function test_lead_supplier_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->supplierPaymentMethod());
    }

    public function test_lead_supplier_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->supplierShipmentMethod());
    }

    public function test_lead_supplier_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->supplierTermOfPayment());
    }

    public function test_lead_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->tax());
    }
}
