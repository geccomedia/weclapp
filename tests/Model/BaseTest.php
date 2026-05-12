<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\Models\Currency;
use Geccomedia\Weclapp\Models\Customer;
use Geccomedia\Weclapp\Models\SalesInvoice;
use Geccomedia\Weclapp\Models\SalesOrder;
use Geccomedia\Weclapp\Models\Unit;
use Geccomedia\Weclapp\Models\WarehouseStock;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class BaseTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    /**
     * @var Model
     */
    private $model;

    protected function setUp(): void
    {
        $this->model = new Unit;
        parent::setUp();
    }

    public function test_date_format_on_base_model()
    {
        $this->assertTrue($this->model->getDateFormat() == 'Uv');
    }

    public function test_created_at_const()
    {
        $this->assertTrue(Model::CREATED_AT == 'createdDate');
    }

    public function test_updated_at_const()
    {
        $this->assertTrue(Model::UPDATED_AT == 'lastModifiedDate');
    }

    public function test_date_conversion()
    {
        Event::fake();

        $now = now();

        $this->assertEquals($now->format('Uv'), $this->model->fromDateTime($now->format('Uv')));
        $this->assertEquals($now->format('Uv'), $this->model->fromDateTime($now));

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1, "invoiceDate": '.$now->format('Uv').'}]}'
            ));

        $invoice = SalesInvoice::find(1);

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql == 'GET:salesInvoice?id-eq=1&pageSize=1';
        });

        $this->assertEquals($now->format('Uv'), $invoice->invoiceDate->format('Uv'));

        $new_invoice = new SalesInvoice;
        $new_invoice->invoiceDate = $now->toDateString();
        $this->assertEquals($now->startOfDay(), $new_invoice->invoiceDate);
    }

    public function test_model_key_type_is_string(): void
    {
        $this->assertSame('string', (new SalesOrder)->getKeyType());
        $this->assertSame('string', (new Customer)->getKeyType());
        $this->assertSame('string', (new Unit)->getKeyType());
    }

    /**
     * getTable() on a model with an explicit $table property must return that
     * value directly (the isset($this->table) early-return branch).
     */
    public function test_get_table_returns_explicit_table_property(): void
    {
        // Customer declares protected $table = 'party'
        $customer = new Customer;

        $this->assertSame('party', $customer->getTable());
    }

    /**
     * callAction() called on an instance with $exists = true must route to
     * the instance endpoint (Builder::callAction), not the collection endpoint.
     */
    public function test_call_action_on_existing_instance_routes_to_instance_endpoint(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], '{"result": "ok"}'));

        $order = new SalesOrder;
        $order->exists = true;
        $order->id = '42';

        $order->callAction('createShipment');

        Event::assertDispatched(QueryExecuted::class, function ($event) {
            return (string) $event->sql === 'POST:salesOrder/id/42/createShipment';
        });
    }

    /**
     * belongsTo() with an explicit $foreignKey argument must use the provided
     * key name instead of the auto-derived camelCase default.
     */
    public function test_belongs_to_with_explicit_foreign_key(): void
    {
        $stock = new WarehouseStock;

        // article() passes 'articleId' explicitly — this exercises the
        // is_null($foreignKey) === false branch in Model::belongsTo()
        $relation = $stock->article();

        $this->assertInstanceOf(
            BelongsTo::class,
            $relation
        );
        $this->assertSame('articleId', $relation->getForeignKeyName());
    }

    /**
     * belongsTo() with no explicit $foreignKey must auto-derive it as
     * lcfirst(RelatedClass) . 'Id' — exercises the is_null($foreignKey)
     * === true branch (line 90 of Model.php).
     */
    public function test_belongs_to_auto_derives_foreign_key(): void
    {
        // Party::invoiceRecipient() calls $this->belongsTo(Party::class, 'invoiceRecipientId')
        // — that is the explicit-key path. Instead, call belongsTo() directly
        // without a foreign key so the auto-derive branch fires.
        $order = new SalesOrder;

        // Calling with null foreignKey triggers: $foreignKey = lcfirst('Currency') . 'id' = 'currencyid'
        $relation = $order->belongsTo(Currency::class);

        $this->assertInstanceOf(
            BelongsTo::class,
            $relation
        );
        // Auto-derived: lcfirst('Currency') . getKeyName() = 'currencyid'
        $this->assertSame('currencyid', $relation->getForeignKeyName());
    }
}
