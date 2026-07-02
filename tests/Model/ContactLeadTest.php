<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Contact;
use Geccomedia\Weclapp\Models\Lead;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Covers all methods declared directly on Contact and Lead.
 *
 * Both models extend Party (which already has the shared BelongsTo block)
 * and add a handful of their own relations on top.
 * Contact and Lead both use $table = 'party'.
 */
class ContactLeadTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    // =========================================================================
    // Contact
    // =========================================================================

    public function test_contact_table_is_party(): void
    {
        $this->assertSame('party', (new Contact)->getTable());
    }

    public function test_contact_party_type_defaults_to_person(): void
    {
        $this->assertSame('PERSON', (new Contact)->partyType);
    }

    /** Contact re-declares all shared BelongsTo methods. */
    public function test_contact_commercial_language_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->commercialLanguage());
    }

    public function test_contact_company_size_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->companySize());
    }

    public function test_contact_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->currency());
    }

    public function test_contact_customer_category_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->customerCategory());
    }

    public function test_contact_customer_current_sales_stage_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->customerCurrentSalesStage());
    }

    public function test_contact_customer_debtor_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->customerDebtorAccount());
    }

    public function test_contact_customer_default_shipping_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->customerDefaultShippingCarrier());
    }

    public function test_contact_customer_default_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->customerDefaultWarehouse());
    }

    public function test_contact_customer_loss_reason_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->customerLossReason());
    }

    public function test_contact_customer_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->customerNonStandardTax());
    }

    public function test_contact_customer_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->customerPaymentMethod());
    }

    public function test_contact_customer_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->customerShipmentMethod());
    }

    public function test_contact_customer_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->customerTermOfPayment());
    }

    public function test_contact_invoice_recipient_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->invoiceRecipient());
    }

    public function test_contact_lead_source_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->leadSource());
    }

    public function test_contact_parent_party_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->parentParty());
    }

    public function test_contact_primary_contact_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->primaryContact());
    }

    public function test_contact_region_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->region());
    }

    public function test_contact_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->responsibleUser());
    }

    public function test_contact_sector_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->sector());
    }

    public function test_contact_supplier_creditor_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->supplierCreditorAccount());
    }

    public function test_contact_supplier_default_shipping_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->supplierDefaultShippingCarrier());
    }

    public function test_contact_supplier_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->supplierNonStandardTax());
    }

    public function test_contact_supplier_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->supplierPaymentMethod());
    }

    public function test_contact_supplier_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->supplierShipmentMethod());
    }

    public function test_contact_supplier_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->supplierTermOfPayment());
    }

    public function test_contact_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->tax());
    }

    /** Contact-only relations */
    public function test_contact_customer_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->customer());
    }

    public function test_contact_lead_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->lead());
    }

    public function test_contact_lead_rating_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->leadRating());
    }

    public function test_contact_legal_form_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->legalForm());
    }

    public function test_contact_person_department_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->personDepartment());
    }

    public function test_contact_person_role_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->personRole());
    }

    public function test_contact_title_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contact)->title());
    }

    // =========================================================================
    // Lead
    // =========================================================================

    public function test_lead_table_is_party(): void
    {
        $this->assertSame('party', (new Lead)->getTable());
    }

    public function test_lead_lead_rating_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->leadRating());
    }

    public function test_lead_legal_form_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->legalForm());
    }

    public function test_lead_person_department_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->personDepartment());
    }

    public function test_lead_person_role_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->personRole());
    }

    public function test_lead_title_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Lead)->title());
    }
}
