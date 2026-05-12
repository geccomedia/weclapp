<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\PaymentMethod;
use Geccomedia\Weclapp\Models\PaymentRunItem;
use Geccomedia\Weclapp\Models\PurchaseOpenItem;
use Geccomedia\Weclapp\Models\SalesOpenItem;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class PaymentTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // -------------------------------------------------------------------------
    // PaymentMethod – relations
    // -------------------------------------------------------------------------

    public function test_payment_method_clearing_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PaymentMethod)->clearingAccount());
    }

    public function test_payment_method_sales_orders_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new PaymentMethod)->salesOrders());
    }

    public function test_payment_method_purchase_orders_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new PaymentMethod)->purchaseOrders());
    }

    // -------------------------------------------------------------------------
    // PaymentRunItem – relations
    // -------------------------------------------------------------------------

    public function test_payment_run_item_bank_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PaymentRunItem)->bankAccount());
    }

    public function test_payment_run_item_payment_run_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PaymentRunItem)->paymentRun());
    }

    public function test_payment_run_item_purchase_open_item_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PaymentRunItem)->purchaseOpenItem());
    }

    public function test_payment_run_item_bank_transaction_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PaymentRunItem)->bankTransaction());
    }

    // -------------------------------------------------------------------------
    // SalesOpenItem – relations
    // -------------------------------------------------------------------------

    public function test_sales_open_item_sales_invoice_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new SalesOpenItem)->salesInvoice());
    }

    // -------------------------------------------------------------------------
    // SalesOpenItem – instance-level POST actions (exists=true)
    // -------------------------------------------------------------------------

    public function test_sales_open_item_create_payment_application_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new SalesOpenItem;
        $model->exists = true;
        $model->id = '1';
        $model->createPaymentApplication();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOpenItem/id/1/createPaymentApplication'));
    }

    public function test_sales_open_item_update_payment_state_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new SalesOpenItem;
        $model->exists = true;
        $model->id = '1';
        $model->updatePaymentState();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:salesOpenItem/id/1/updatePaymentState'));
    }

    // -------------------------------------------------------------------------
    // PurchaseOpenItem – relations
    // -------------------------------------------------------------------------

    public function test_purchase_open_item_purchase_invoice_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PurchaseOpenItem)->purchaseInvoice());
    }

    // -------------------------------------------------------------------------
    // PurchaseOpenItem – instance-level POST actions (exists=true)
    // -------------------------------------------------------------------------

    public function test_purchase_open_item_create_payment_application_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new PurchaseOpenItem;
        $model->exists = true;
        $model->id = '1';
        $model->createPaymentApplication();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOpenItem/id/1/createPaymentApplication'));
    }

    public function test_purchase_open_item_update_payment_state_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new PurchaseOpenItem;
        $model->exists = true;
        $model->id = '1';
        $model->updatePaymentState();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:purchaseOpenItem/id/1/updatePaymentState'));
    }
}
