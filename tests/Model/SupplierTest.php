<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Supplier;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Covers the 27 shared BelongsTo methods re-declared on Supplier,
 * plus the 7 Supplier-specific BelongsTo and 2 HasMany relations.
 * $table = 'party'.
 */
class SupplierTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_supplier_table_is_party(): void
    {
        $this->assertSame('party', (new Supplier)->getTable());
    }

    public function test_supplier_flag_defaults_to_true(): void
    {
        $this->assertTrue((new Supplier)->supplier);
    }

    public function test_supplier_party_type_defaults_to_organization(): void
    {
        $this->assertSame('ORGANIZATION', (new Supplier)->partyType);
    }

    // -------------------------------------------------------------------------
    // Shared BelongsTo (re-declared on Supplier)
    // -------------------------------------------------------------------------

    public function test_commercial_language_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->commercialLanguage());
    }

    public function test_company_size_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->companySize());
    }

    public function test_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->currency());
    }

    public function test_customer_category_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->customerCategory());
    }

    public function test_customer_current_sales_stage_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->customerCurrentSalesStage());
    }

    public function test_customer_debtor_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->customerDebtorAccount());
    }

    public function test_customer_default_shipping_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->customerDefaultShippingCarrier());
    }

    public function test_customer_default_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->customerDefaultWarehouse());
    }

    public function test_customer_loss_reason_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->customerLossReason());
    }

    public function test_customer_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->customerNonStandardTax());
    }

    public function test_customer_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->customerPaymentMethod());
    }

    public function test_customer_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->customerShipmentMethod());
    }

    public function test_customer_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->customerTermOfPayment());
    }

    public function test_invoice_recipient_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->invoiceRecipient());
    }

    public function test_lead_source_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->leadSource());
    }

    public function test_parent_party_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->parentParty());
    }

    public function test_primary_contact_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->primaryContact());
    }

    public function test_region_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->region());
    }

    public function test_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->responsibleUser());
    }

    public function test_sector_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->sector());
    }

    public function test_supplier_creditor_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->supplierCreditorAccount());
    }

    public function test_supplier_default_shipping_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->supplierDefaultShippingCarrier());
    }

    public function test_supplier_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->supplierNonStandardTax());
    }

    public function test_supplier_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->supplierPaymentMethod());
    }

    public function test_supplier_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->supplierShipmentMethod());
    }

    public function test_supplier_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->supplierTermOfPayment());
    }

    public function test_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->tax());
    }

    // -------------------------------------------------------------------------
    // Supplier-specific BelongsTo relations
    // -------------------------------------------------------------------------

    public function test_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->paymentMethod());
    }

    public function test_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->termOfPayment());
    }

    public function test_lead_rating_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->leadRating());
    }

    public function test_legal_form_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->legalForm());
    }

    public function test_person_department_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->personDepartment());
    }

    public function test_person_role_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->personRole());
    }

    public function test_title_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Supplier)->title());
    }

    // -------------------------------------------------------------------------
    // HasMany relations
    // -------------------------------------------------------------------------

    public function test_purchase_orders_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Supplier)->purchaseOrders());
    }

    public function test_incoming_goods_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Supplier)->incomingGoods());
    }
}
