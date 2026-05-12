<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\PurchaseOrder;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class PurchaseOrderActionsTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    private function makeOrder(): PurchaseOrder
    {
        $o = new PurchaseOrder;
        $o->exists = true;
        $o->id = '1';

        return $o;
    }

    public function test_cancel_dropshipping_shipments_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->cancelDropshippingShipments();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOrder/id/1/cancelDropshippingShipments'));
    }

    public function test_create_cancellation_slip_pdf_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createCancellationSlipPdf();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOrder/id/1/createCancellationSlipPdf'));
    }

    public function test_create_contract_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createContract();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOrder/id/1/createContract'));
    }

    public function test_create_dropshipping_delivery_note_pdf_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createDropshippingDeliveryNotePdf();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOrder/id/1/createDropshippingDeliveryNotePdf'));
    }

    public function test_create_incoming_goods_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createIncomingGoods();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOrder/id/1/createIncomingGoods'));
    }

    public function test_create_production_orders_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createProductionOrders();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOrder/id/1/createProductionOrders'));
    }

    public function test_create_purchase_invoice_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createPurchaseInvoice();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOrder/id/1/createPurchaseInvoice'));
    }

    public function test_create_supplier_return_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createSupplierReturn();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOrder/id/1/createSupplierReturn'));
    }

    public function test_download_latest_cancellation_slip_pdf_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->downloadLatestCancellationSlipPdf();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:purchaseOrder/id/1/downloadLatestCancellationSlipPdf'));
    }

    public function test_download_latest_dropshipping_delivery_note_pdf_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->downloadLatestDropshippingDeliveryNotePdf();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:purchaseOrder/id/1/downloadLatestDropshippingDeliveryNotePdf'));
    }

    public function test_download_latest_purchase_order_pdf_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->downloadLatestPurchaseOrderPdf();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:purchaseOrder/id/1/downloadLatestPurchaseOrderPdf'));
    }

    public function test_print_label_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->printLabel();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOrder/id/1/printLabel'));
    }

    public function test_process_dropshipping_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->processDropshipping();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOrder/id/1/processDropshipping'));
    }

    public function test_reset_taxes_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->resetTaxes();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOrder/id/1/resetTaxes'));
    }
}
