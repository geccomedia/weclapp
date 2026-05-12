<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Party;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Covers all BelongsTo relation methods defined directly on Party.
 * Party is not abstract — it can be instantiated directly.
 * Action methods are covered separately in ModelCoveragePartyActionsTest.
 */
class PartyTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_party_table_is_party(): void
    {
        $this->assertSame('party', (new Party)->getTable());
    }

    public function test_commercial_language_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->commercialLanguage());
    }

    public function test_company_size_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->companySize());
    }

    public function test_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->currency());
    }

    public function test_customer_category_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->customerCategory());
    }

    public function test_customer_current_sales_stage_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->customerCurrentSalesStage());
    }

    public function test_customer_debtor_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->customerDebtorAccount());
    }

    public function test_customer_default_shipping_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->customerDefaultShippingCarrier());
    }

    public function test_customer_default_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->customerDefaultWarehouse());
    }

    public function test_customer_loss_reason_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->customerLossReason());
    }

    public function test_customer_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->customerNonStandardTax());
    }

    public function test_customer_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->customerPaymentMethod());
    }

    public function test_customer_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->customerShipmentMethod());
    }

    public function test_customer_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->customerTermOfPayment());
    }

    public function test_invoice_recipient_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->invoiceRecipient());
    }

    public function test_lead_source_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->leadSource());
    }

    public function test_parent_party_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->parentParty());
    }

    public function test_primary_contact_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->primaryContact());
    }

    public function test_region_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->region());
    }

    public function test_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->responsibleUser());
    }

    public function test_sector_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->sector());
    }

    public function test_supplier_creditor_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->supplierCreditorAccount());
    }

    public function test_supplier_default_shipping_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->supplierDefaultShippingCarrier());
    }

    public function test_supplier_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->supplierNonStandardTax());
    }

    public function test_supplier_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->supplierPaymentMethod());
    }

    public function test_supplier_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->supplierShipmentMethod());
    }

    public function test_supplier_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->supplierTermOfPayment());
    }

    public function test_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->tax());
    }

    public function test_lead_rating_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->leadRating());
    }

    public function test_legal_form_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->legalForm());
    }

    public function test_person_department_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->personDepartment());
    }

    public function test_person_role_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->personRole());
    }

    public function test_title_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Party)->title());
    }
}
