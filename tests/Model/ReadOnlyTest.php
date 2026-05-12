<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\BankTransaction;
use Geccomedia\Weclapp\Models\CashAccount;
use Geccomedia\Weclapp\Models\SalesOrder;
use Geccomedia\Weclapp\Models\SerialNumber;
use Geccomedia\Weclapp\Models\WarehouseStock;
use Geccomedia\Weclapp\NotSupportedException;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ReadOnlyTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    /**
     * BankTransaction uses NoCreate, so save() on a new instance must throw.
     */
    public function test_no_create_trait_throws_on_save(): void
    {
        $this->expectException(NotSupportedException::class);

        (new BankTransaction)->save();
    }

    /**
     * Calling save() on a new WarehouseStock (uses IsReadOnly → NoCreate) must throw.
     */
    public function test_non_creatable_model_throws_on_save(): void
    {
        $this->expectException(NotSupportedException::class);

        $stock = new WarehouseStock;
        $stock->save();
    }

    /**
     * Calling delete() on an existing WarehouseStock (uses IsReadOnly → NoDelete) must throw.
     */
    public function test_non_deletable_model_throws_on_delete(): void
    {
        $this->expectException(NotSupportedException::class);

        $stock = new WarehouseStock;
        $stock->exists = true;
        $stock->id = '1';
        $stock->delete();
    }

    /**
     * Calling delete() on an existing CashAccount (uses NoDelete) must throw.
     */
    public function test_cash_account_non_deletable_throws_on_delete(): void
    {
        $this->expectException(NotSupportedException::class);

        $account = new CashAccount;
        $account->exists = true;
        $account->id = '1';
        $account->delete();
    }

    /**
     * CashAccount is creatable (no $creatable=false), so save() on a new
     * instance must NOT throw — it should proceed to the HTTP layer.
     * We mock the Client so it never actually hits the network.
     */
    public function test_creatable_model_does_not_throw_on_save(): void
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(201, [], '{"id": "1"}'));

        $account = new CashAccount;
        $account->save(); // must not throw NotSupportedException

        $this->assertTrue($account->exists);
    }

    /**
     * SalesOrder is both creatable and deletable (defaults), so delete() must
     * NOT throw — the HTTP layer handles it.
     */
    public function test_deletable_model_does_not_throw_on_delete(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(204));

        $order = new SalesOrder;
        $order->exists = true;
        $order->id = '1';
        $order->delete(); // must not throw NotSupportedException

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql === 'DELETE:salesOrder/id/1';
        });
    }

    /**
     * Calling save() on an existing BankTransaction (updatable=false) must throw.
     */
    public function test_non_updatable_model_throws_on_save(): void
    {
        $this->expectException(NotSupportedException::class);

        $tx = new BankTransaction;
        $tx->exists = true;
        $tx->id = '1';
        $tx->save();
    }

    /**
     * SalesOrder is updatable by default, so save() on an existing instance
     * must NOT throw — the HTTP layer handles it.
     */
    public function test_updatable_model_does_not_throw_on_save(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(201, [], '{"id": "1"}'));

        $order = new SalesOrder;
        $order->exists = true;
        $order->id = '1';
        $order->save(); // must not throw NotSupportedException

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return str_contains((string) $event->sql, 'PUT:salesOrder');
        });
    }

    /**
     * SerialNumber uses IsUpdatableOnly: save() on a new instance must throw
     * (no POST endpoint), but save() on an existing instance must not throw
     * (PUT is allowed).
     */
    public function test_is_updatable_only_blocks_create_but_not_update(): void
    {
        // Creating a new SerialNumber must throw
        $this->expectException(NotSupportedException::class);
        (new SerialNumber)->save();
    }

    public function test_is_updatable_only_allows_update(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(201, [], '{"id": "42"}'));

        $sn = new SerialNumber;
        $sn->exists = true;
        $sn->id = '42';
        $sn->save(); // PUT — must not throw

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return str_contains((string) $event->sql, 'PUT:serialNumber');
        });
    }

    /**
     * Deleting a SerialNumber (IsUpdatableOnly, no DELETE) must throw.
     */
    public function test_is_updatable_only_blocks_delete(): void
    {
        $this->expectException(NotSupportedException::class);

        $sn = new SerialNumber;
        $sn->exists = true;
        $sn->id = '42';
        $sn->delete();
    }

    /**
     * Calling save() on an existing WarehouseStock (updatable=false via IsReadOnly)
     * must throw NotSupportedException — the performUpdate branch of IsReadOnly.
     */
    public function test_is_readonly_model_throws_on_update(): void
    {
        $this->expectException(NotSupportedException::class);

        $stock = new WarehouseStock;
        $stock->exists = true;
        $stock->id = '1';
        $stock->save();
    }
}
