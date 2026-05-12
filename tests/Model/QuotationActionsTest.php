<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Quotation;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class QuotationActionsTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    private function makeQuotation(): Quotation
    {
        $q = new Quotation;
        $q->exists = true;
        $q->id = '1';

        return $q;
    }

    public function test_accept_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->accept();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:quotation/id/1/accept'));
    }

    public function test_add_default_scale_prices_to_items_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->addDefaultScalePricesToItems();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:quotation/id/1/addDefaultScalePricesToItems'));
    }

    public function test_calculate_sales_prices_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->calculateSalesPrices();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:quotation/id/1/calculateSalesPrices'));
    }

    public function test_create_new_version_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->createNewVersion();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:quotation/id/1/createNewVersion'));
    }

    public function test_create_public_page_link_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->createPublicPageLink();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:quotation/id/1/createPublicPageLink'));
    }

    public function test_create_purchase_order_request_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->createPurchaseOrderRequest();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:quotation/id/1/createPurchaseOrderRequest'));
    }

    public function test_create_quotation_pdf_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->createQuotationPdf();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:quotation/id/1/createQuotationPdf'));
    }

    public function test_disable_public_page_link_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->disablePublicPageLink();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:quotation/id/1/disablePublicPageLink'));
    }

    public function test_download_latest_quotation_pdf_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->downloadLatestQuotationPdf();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:quotation/id/1/downloadLatestQuotationPdf'));
    }

    public function test_inquire_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->inquire();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:quotation/id/1/inquire'));
    }

    public function test_print_label_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->printLabel();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:quotation/id/1/printLabel'));
    }

    public function test_print_quotation_data_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->printQuotationData();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:quotation/id/1/printQuotationData'));
    }

    public function test_recalculate_costs_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->recalculateCosts();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:quotation/id/1/recalculateCosts'));
    }

    public function test_reset_taxes_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->resetTaxes();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:quotation/id/1/resetTaxes'));
    }

    public function test_set_costs_for_items_without_cost_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->setCostsForItemsWithoutCost();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:quotation/id/1/setCostsForItemsWithoutCost'));
    }

    public function test_update_prices_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeQuotation()->updatePrices();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:quotation/id/1/updatePrices'));
    }
}
