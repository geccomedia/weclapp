<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\SalesInvoice;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class SalesInvoiceActionsTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    private function makeInvoice(): SalesInvoice
    {
        $i = new SalesInvoice;
        $i->exists = true;
        $i->id = '1';

        return $i;
    }

    public function test_add_sales_orders_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInvoice()->addSalesOrders();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesInvoice/id/1/addSalesOrders'));
    }

    public function test_calculate_sales_prices_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInvoice()->calculateSalesPrices();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesInvoice/id/1/calculateSalesPrices'));
    }

    public function test_cancel_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInvoice()->cancel();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesInvoice/id/1/cancel'));
    }

    public function test_create_contract_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInvoice()->createContract();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesInvoice/id/1/createContract'));
    }

    public function test_create_credit_note_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInvoice()->createCreditNote();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesInvoice/id/1/createCreditNote'));
    }

    public function test_create_credit_note_open_item_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInvoice()->createCreditNoteOpenItem();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesInvoice/id/1/createCreditNoteOpenItem'));
    }

    public function test_download_latest_sales_invoice_pdf_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInvoice()->downloadLatestSalesInvoicePdf();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:salesInvoice/id/1/downloadLatestSalesInvoicePdf'));
    }

    public function test_print_label_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInvoice()->printLabel();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesInvoice/id/1/printLabel'));
    }

    public function test_recalculate_costs_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInvoice()->recalculateCosts();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesInvoice/id/1/recalculateCosts'));
    }

    public function test_reset_taxes_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInvoice()->resetTaxes();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesInvoice/id/1/resetTaxes'));
    }

    public function test_set_costs_for_items_without_cost_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInvoice()->setCostsForItemsWithoutCost();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesInvoice/id/1/setCostsForItemsWithoutCost'));
    }

    public function test_update_prices_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeInvoice()->updatePrices();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesInvoice/id/1/updatePrices'));
    }
}
