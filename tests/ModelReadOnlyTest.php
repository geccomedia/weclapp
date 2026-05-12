<?php

namespace Geccomedia\Weclapp\Tests;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\CashAccount;
use Geccomedia\Weclapp\Models\SalesOrder;
use Geccomedia\Weclapp\Models\WarehouseStock;
use Geccomedia\Weclapp\NotSupportedException;
use Geccomedia\Weclapp\ServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ModelReadOnlyTest extends OrchestraTestCase
{
    /**
     * @param  Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    /**
     * Calling save() on a new WarehouseStock (creatable=false) must throw.
     */
    public function test_non_creatable_model_throws_on_save(): void
    {
        $this->expectException(NotSupportedException::class);

        $stock = new WarehouseStock;
        $stock->save();
    }

    /**
     * Calling delete() on an existing WarehouseStock (deletable=false) must throw.
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
     * Calling delete() on an existing CashAccount (deletable=false) must throw.
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
}
