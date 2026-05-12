<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\PurchaseInvoice;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class PurchaseInvoiceTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // -------------------------------------------------------------------------
    // BelongsTo relations
    // -------------------------------------------------------------------------

    public function test_cost_center_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseInvoice)->costCenter());
    }

    public function test_cost_type_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseInvoice)->costType());
    }

    public function test_creator_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseInvoice)->creator());
    }

    public function test_import_sales_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseInvoice)->importSalesTax());
    }

    public function test_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseInvoice)->nonStandardTax());
    }

    public function test_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseInvoice)->paymentMethod());
    }

    public function test_preceding_purchase_invoice_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseInvoice)->precedingPurchaseInvoice());
    }

    public function test_record_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseInvoice)->recordCurrency());
    }

    public function test_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseInvoice)->responsibleUser());
    }

    public function test_supplier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseInvoice)->supplier());
    }

    public function test_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseInvoice)->termOfPayment());
    }

    // -------------------------------------------------------------------------
    // Instance-level actions (POST/GET, exists=true)
    // -------------------------------------------------------------------------

    private function makePurchaseInvoice(): PurchaseInvoice
    {
        $m = new PurchaseInvoice;
        $m->exists = true;
        $m->id = '1';

        return $m;
    }

    public function test_cancel_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makePurchaseInvoice()->cancel();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseInvoice/id/1/cancel'));
    }

    public function test_convert_purchase_invoice_to_credit_note_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makePurchaseInvoice()->convertPurchaseInvoiceToCreditNote();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseInvoice/id/1/convertPurchaseInvoiceToCreditNote'));
    }

    public function test_create_contract_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makePurchaseInvoice()->createContract();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseInvoice/id/1/createContract'));
    }

    public function test_create_credit_note_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makePurchaseInvoice()->createCreditNote();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseInvoice/id/1/createCreditNote'));
    }

    public function test_download_latest_purchase_invoice_document_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makePurchaseInvoice()->downloadLatestPurchaseInvoiceDocument();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:purchaseInvoice/id/1/downloadLatestPurchaseInvoiceDocument'));
    }

    public function test_print_label_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makePurchaseInvoice()->printLabel();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseInvoice/id/1/printLabel'));
    }

    public function test_reset_taxes_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makePurchaseInvoice()->resetTaxes();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseInvoice/id/1/resetTaxes'));
    }

    public function test_save_duplicate_invoice_as_original_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makePurchaseInvoice()->saveDuplicateInvoiceAsOriginal();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseInvoice/id/1/saveDuplicateInvoiceAsOriginal'));
    }

    public function test_start_invoice_document_processing_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makePurchaseInvoice()->startInvoiceDocumentProcessing();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseInvoice/id/1/startInvoiceDocumentProcessing'));
    }
}
