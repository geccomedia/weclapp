<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\SalesOrder;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Covers the first batch of SalesOrder action methods (instance POST/GET).
 * All actions below operate on an existing instance (exists=true, id='1').
 */
class SalesOrderActionsTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    private function makeOrder(): SalesOrder
    {
        $order = new SalesOrder;
        $order->exists = true;
        $order->id = '1';

        return $order;
    }

    public function test_activate_project_view_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->activateProjectView();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/activateProjectView'));
    }

    public function test_calculate_sales_prices_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->calculateSalesPrices();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/calculateSalesPrices'));
    }

    public function test_cancel_or_manually_close_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->cancelOrManuallyClose();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/cancelOrManuallyClose'));
    }

    public function test_create_advance_payment_request_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createAdvancePaymentRequest();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/createAdvancePaymentRequest'));
    }

    public function test_create_contract_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createContract();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/createContract'));
    }

    public function test_create_customer_return_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createCustomerReturn();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/createCustomerReturn'));
    }

    public function test_create_dropshipping_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createDropshipping();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/createDropshipping'));
    }

    public function test_create_part_payment_invoice_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createPartPaymentInvoice();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/createPartPaymentInvoice'));
    }

    public function test_create_performance_record_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createPerformanceRecord();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/createPerformanceRecord'));
    }

    public function test_create_prepayment_final_invoice_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createPrepaymentFinalInvoice();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/createPrepaymentFinalInvoice'));
    }

    public function test_create_production_orders_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createProductionOrders();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/createProductionOrders'));
    }

    public function test_create_purchase_order_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createPurchaseOrder();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/createPurchaseOrder'));
    }

    public function test_create_purchase_order_request_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createPurchaseOrderRequest();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/createPurchaseOrderRequest'));
    }

    public function test_create_return_labels_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createReturnLabels();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/createReturnLabels'));
    }

    public function test_create_sales_invoice_action(): void
    {
        Event::fake();
        $this->mockClient();
        $this->makeOrder()->createSalesInvoice();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOrder/id/1/createSalesInvoice'));
    }
}
