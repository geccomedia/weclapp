<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Customer;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Covers all methods declared directly on Customer.
 * Note: Customer extends Model (not Party), so action methods
 * (createPublicPage, downloadImage, etc.) live on Party and are
 * tested in ModelCoveragePartyTest.
 */
class CustomerTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    // -------------------------------------------------------------------------
    // Constructor defaults
    // -------------------------------------------------------------------------

    public function test_customer_flag_defaults_to_true(): void
    {
        $this->assertTrue((new Customer)->customer);
    }

    public function test_party_type_defaults_to_organization(): void
    {
        $this->assertSame('ORGANIZATION', (new Customer)->partyType);
    }

    // -------------------------------------------------------------------------
    // Structural / table
    // -------------------------------------------------------------------------

    public function test_customer_table_is_party(): void
    {
        $this->assertSame('party', (new Customer)->getTable());
    }

    // -------------------------------------------------------------------------
    // BelongsTo relations declared on Customer
    // -------------------------------------------------------------------------

    public function test_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->paymentMethod());
    }

    public function test_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->termOfPayment());
    }

    public function test_lead_rating_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->leadRating());
    }

    public function test_legal_form_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->legalForm());
    }

    public function test_person_department_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->personDepartment());
    }

    public function test_person_role_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->personRole());
    }

    public function test_title_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->title());
    }

    // Shared BelongsTo methods re-declared on Customer

    public function test_commercial_language_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->commercialLanguage());
    }

    public function test_company_size_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->companySize());
    }

    public function test_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->currency());
    }

    public function test_customer_category_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->customerCategory());
    }

    public function test_customer_current_sales_stage_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->customerCurrentSalesStage());
    }

    public function test_customer_debtor_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->customerDebtorAccount());
    }

    public function test_customer_default_shipping_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->customerDefaultShippingCarrier());
    }

    public function test_customer_default_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->customerDefaultWarehouse());
    }

    public function test_customer_loss_reason_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->customerLossReason());
    }

    public function test_customer_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->customerNonStandardTax());
    }

    public function test_customer_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->customerPaymentMethod());
    }

    public function test_customer_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->customerShipmentMethod());
    }

    public function test_customer_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->customerTermOfPayment());
    }

    public function test_invoice_recipient_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->invoiceRecipient());
    }

    public function test_lead_source_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->leadSource());
    }

    public function test_parent_party_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->parentParty());
    }

    public function test_primary_contact_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->primaryContact());
    }

    public function test_region_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->region());
    }

    public function test_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->responsibleUser());
    }

    public function test_sector_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->sector());
    }

    public function test_supplier_creditor_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->supplierCreditorAccount());
    }

    public function test_supplier_default_shipping_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->supplierDefaultShippingCarrier());
    }

    public function test_supplier_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->supplierNonStandardTax());
    }

    public function test_supplier_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->supplierPaymentMethod());
    }

    public function test_supplier_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->supplierShipmentMethod());
    }

    public function test_supplier_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->supplierTermOfPayment());
    }

    public function test_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Customer)->tax());
    }

    // -------------------------------------------------------------------------
    // HasMany relations
    // -------------------------------------------------------------------------

    public function test_sales_orders_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Customer)->salesOrders());
    }

    public function test_quotations_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Customer)->quotations());
    }

    public function test_sales_invoices_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Customer)->salesInvoices());
    }

    public function test_shipments_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Customer)->shipments());
    }

    public function test_contacts_has_many_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Customer)->contacts());
    }
}
