<?php namespace Geccomedia\Weclapp\Tests;

use Geccomedia\Weclapp\Models\Customer;
use Geccomedia\Weclapp\Models\SalesInvoice;
use Geccomedia\Weclapp\Models\Unit;
use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\NotSupportedException;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Str;

class ModelFunctionTest extends TestCase
{
    /**
     * @var Model
     */
    private $model;

    public function setUp(): void
    {
        $this->model = $this->getMockForAbstractClass('Geccomedia\Weclapp\Model');
        parent::setUp();
    }

    public function testDateFormatOnBaseModel()
    {
        $this->assertTrue($this->model->getDateFormat() == 'U');
    }

    public function testCreatedAtConst()
    {
        $this->assertTrue(Model::CREATED_AT == 'createdDate');
    }

    public function testUpdatedAtConst()
    {
        $this->assertTrue(Model::UPDATED_AT == 'lastModifiedDate');
    }

    public function testDateConversion()
    {
        $now = now();

        $this->assertEquals($now->timestamp * 1000, $this->model->fromDateTime($now));

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1, "invoiceDate": '.($now->timestamp * 1000).'}]}'
            ));

        $invoice = SalesInvoice::find(1);

        $this->assertEquals($now->timestamp, $invoice->invoiceDate->timestamp);
    }

    public function testApiGet()
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1},{"id": 2}]}'
            ));

        $units = Unit::select('1')
            ->where('2', 3)
            ->orderBy(4, 'DESC')
            ->limit(5)
            ->skip(4)
            ->get();

        $this->assertEquals(2, $units->count());

        $this->assertEquals(1, $units->first()->id);
    }

    public function testNotFound()
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(404));

        $unit = Unit::find(1);

        $this->assertNull($unit);
    }

    public function testApiGetAll()
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1},{"id": 2}]}'
            ));

        $units = Unit::whereNotIn('test', [1, 2])
            ->whereNull('test2')
            ->whereNotNull('test3')
            ->get();

        $this->assertEquals(2, $units->count());
    }

    public function testApiCount()
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": 55}'
            ));

        $count = Unit::where('1', 2)->count();

        $this->assertEquals(55, $count);
    }

    public function testFindMany()
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1},{"id": 2}]}'
            ));

        $units = Unit::findMany([1, 2]);

        $this->assertEquals(2, $units->count());

        $this->assertEquals(1, $units->first()->id);
    }

    public function testApiDelete()
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(204));

        $deleted = Unit::whereKey(1)
            ->delete();

        $this->assertTrue($deleted);

        $this->expectException(NotSupportedException::class);

        Unit::where('this', 'that')
            ->delete();
    }

    public function testApiInsert()
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(new Response(
                201,
                [],
                '{"id": 1, "test": "bla", "remote": "test"}'
            ));

        $unit = new Unit();
        $unit->test = 'bla';
        $unit->save();

        $this->assertTrue($unit->exists);
        $this->assertEquals(1, $unit->id);
        $this->assertEquals('bla', $unit->test);
        $this->assertEquals('test', $unit->remote);

        Unit::insert(['test' => 1]);
    }

    public function testApiMultiInsertFails()
    {
        $this->expectException(NotSupportedException::class);

        Unit::insert([
            ['test' => 1],
            ['test' => 2],
        ]);
    }

    public function testApiUpdate()
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1}]}'
            ));

        $unit = Unit::find(1);

        $this->assertTrue($unit->exists);
        $this->assertEquals(1, $unit->id);

        $unit->name = Str::random();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1, "name": ' . $unit->name . '}]}'
            ));

        $this->assertTrue($unit->isDirty());

        $unit->save();

        $this->assertTrue($unit->isClean());
    }

    public function testApiUpdateNotSupported()
    {
        $this->expectException(NotSupportedException::class);

        Unit::whereNull('this')
            ->update(['this' => 'that']);
    }

    public function testConnection()
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": 1},{"id": 2}]}'
            ));

        $connection = (new Unit)->getConnection();

        $query = $connection->table('test');

        $this->assertEquals('test', $query->toSql()->getUri()->getPath());

        $request = $connection->getQueryGrammar()->compileSelect($query);

        $unit = $connection->selectOne($request);

        $this->assertArrayHasKey('id', $unit);
    }

    public function testCustomerPartyType()
    {
        $customer = new Customer();

        $this->assertEquals('ORGANIZATION', $customer->partyType);
    }

    public function testPagination()
    {
        $this->mock(Client::class)
            ->shouldReceive('send')
            ->andReturn(
                new Response(
                    200,
                    [],
                    '{"result": [{"id": 1},{"id": 2}]}'
                ),
                new Response(
                    200,
                    [],
                    '{"result": [{"id": 3},{"id": 4}]}'
                ),
                new Response(
                    200,
                    [],
                    '{"result": [{"id": 5}]}'
                )
            );

        Customer::where('test', 'this')
            ->chunk(2, function($customers, $page){
                if($page < 3){
                    $this->assertCount(2, $customers);
                }
                else{
                    $this->assertCount(1, $customers);
                }
            });

        // assert that we returned from the loop
        $this->assertTrue(true);
    }
}