<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\BlanketPurchaseOrder;
use Geccomedia\Weclapp\Models\BlanketSalesOrder;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class BlanketOrderTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // -------------------------------------------------------------------------
    // BlanketSalesOrder relations
    // -------------------------------------------------------------------------

    public function test_bso_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketSalesOrder)->article());
    }

    public function test_bso_customer_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketSalesOrder)->customer());
    }

    public function test_bso_default_shipping_carrier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketSalesOrder)->defaultShippingCarrier());
    }

    public function test_bso_fulfillment_provider_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketSalesOrder)->fulfillmentProvider());
    }

    public function test_bso_invoice_recipient_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketSalesOrder)->invoiceRecipient());
    }

    public function test_bso_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketSalesOrder)->nonStandardTax());
    }

    public function test_bso_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketSalesOrder)->paymentMethod());
    }

    public function test_bso_record_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketSalesOrder)->recordCurrency());
    }

    public function test_bso_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketSalesOrder)->responsibleUser());
    }

    public function test_bso_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketSalesOrder)->shipmentMethod());
    }

    public function test_bso_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketSalesOrder)->tax());
    }

    public function test_bso_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketSalesOrder)->termOfPayment());
    }

    public function test_bso_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketSalesOrder)->warehouse());
    }

    public function test_bso_creator_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketSalesOrder)->creator());
    }

    // -------------------------------------------------------------------------
    // BlanketSalesOrder actions
    // -------------------------------------------------------------------------

    public function test_bso_download_latest_blanket_sales_order_pdf_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $model = $this->makeInstance(BlanketSalesOrder::class);
        $model->downloadLatestBlanketSalesOrderPdf();
        $this->assertSql('GET:blanketSalesOrder/id/1/downloadLatestBlanketSalesOrderPdf');
    }

    public function test_bso_generate_releases_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $model = $this->makeInstance(BlanketSalesOrder::class);
        $model->generateReleases();
        $this->assertSql('POST:blanketSalesOrder/id/1/generateReleases');
    }

    public function test_bso_update_status_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $model = $this->makeInstance(BlanketSalesOrder::class);
        $model->updateStatus();
        $this->assertSql('POST:blanketSalesOrder/id/1/updateStatus');
    }

    // -------------------------------------------------------------------------
    // BlanketPurchaseOrder relations
    // -------------------------------------------------------------------------

    public function test_bpo_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketPurchaseOrder)->article());
    }

    public function test_bpo_blanket_sales_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketPurchaseOrder)->blanketSalesOrder());
    }

    public function test_bpo_creator_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketPurchaseOrder)->creator());
    }

    public function test_bpo_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketPurchaseOrder)->nonStandardTax());
    }

    public function test_bpo_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketPurchaseOrder)->paymentMethod());
    }

    public function test_bpo_record_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketPurchaseOrder)->recordCurrency());
    }

    public function test_bpo_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketPurchaseOrder)->responsibleUser());
    }

    public function test_bpo_shipment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketPurchaseOrder)->shipmentMethod());
    }

    public function test_bpo_supplier_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketPurchaseOrder)->supplier());
    }

    public function test_bpo_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketPurchaseOrder)->tax());
    }

    public function test_bpo_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketPurchaseOrder)->termOfPayment());
    }

    public function test_bpo_warehouse_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BlanketPurchaseOrder)->warehouse());
    }

    // -------------------------------------------------------------------------
    // BlanketPurchaseOrder actions  (instance: /id/{id}/…)
    // -------------------------------------------------------------------------

    public function test_bpo_download_latest_blanket_purchase_order_pdf_action(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new BlanketPurchaseOrder;
        $model->exists = true;
        $model->id = '1';
        $model->downloadLatestBlanketPurchaseOrderPdf();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:blanketPurchaseOrder/id/1/downloadLatestBlanketPurchaseOrderPdf')
        );
    }

    public function test_bpo_generate_releases_action(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new BlanketPurchaseOrder;
        $model->exists = true;
        $model->id = '1';
        $model->generateReleases();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:blanketPurchaseOrder/id/1/generateReleases')
        );
    }
}
