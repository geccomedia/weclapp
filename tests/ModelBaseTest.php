<?php

namespace Geccomedia\Weclapp\Tests;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\Models\Customer;
use Geccomedia\Weclapp\Models\SalesInvoice;
use Geccomedia\Weclapp\Models\SalesOrder;
use Geccomedia\Weclapp\Models\Unit;
use Geccomedia\Weclapp\ServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ModelBaseTest extends OrchestraTestCase
{
    /**
     * Load package service provider
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

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
}
