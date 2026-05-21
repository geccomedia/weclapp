<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\SalesOrder;
use Geccomedia\Weclapp\SubModel;
use Geccomedia\Weclapp\SubModels\RecordAddress;
use Geccomedia\Weclapp\SubModels\SalesOrderItem;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class SubModelTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    public function test_sub_model_list_is_hydrated_on_fetch(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": "1", "orderItems": [{"articleId": "A1", "quantity": "2", "positionNumber": 10}]}]}'
            ));

        $order = SalesOrder::find('1');

        // The attribute is hydrated into SubModel instances
        $this->assertIsArray($order->orderItems);
        $this->assertCount(1, $order->orderItems);
        $this->assertInstanceOf(SalesOrderItem::class, $order->orderItems[0]);
    }

    public function test_sub_model_single_object_is_hydrated_on_fetch(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": "1", "recordAddress": {"city": "Berlin", "countryCode": "DE"}}]}'
            ));

        $order = SalesOrder::find('1');

        $this->assertInstanceOf(RecordAddress::class, $order->recordAddress);
        $this->assertEquals('Berlin', $order->recordAddress->city);
        $this->assertEquals('DE', $order->recordAddress->countryCode);
    }

    public function test_sub_model_null_attribute_stays_null(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": "1"}]}'
            ));

        $order = SalesOrder::find('1');

        $this->assertNull($order->orderItems);
        $this->assertNull($order->recordAddress);
    }

    public function test_sub_model_array_access_backwards_compat(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": "1", "orderItems": [{"articleId": "A1", "quantity": "2"}]}]}'
            ));

        $order = SalesOrder::find('1');

        // Old array-access style still works
        $this->assertEquals('A1', $order->orderItems[0]['articleId']);
        $this->assertEquals('2', $order->orderItems[0]['quantity']);

        // New object-style also works
        $this->assertEquals('A1', $order->orderItems[0]->articleId);
        $this->assertEquals('2', $order->orderItems[0]->quantity);
    }

    public function test_sub_model_serialises_back_to_plain_arrays_on_save(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->twice()
            ->andReturn(
                new Response(200, [], '{"result": [{"id": "1", "orderItems": [{"articleId": "A1", "quantity": "2"}]}]}'),
                new Response(200, [], '{"result": [{"id": "1"}]}')
            );

        $order = SalesOrder::find('1');

        // Dirty the model so save() actually fires a PUT.
        $order->note = 'updated';
        $order->save();

        // PUT bindings must contain plain arrays, not SubModel objects.
        Event::assertDispatched(QueryExecuted::class, function ($event) {
            if ((string) $event->sql !== 'PUT:salesOrder/id/1') {
                return false;
            }
            $items = $event->bindings['orderItems'] ?? null;

            return is_array($items) && isset($items[0]) && is_array($items[0]);
        });
    }

    public function test_sub_model_cast_resolves_correct_class(): void
    {
        $cast = SalesOrderItem::castUsing([]);
        $result = $cast->get(new SalesOrder, 'orderItems', [['articleId' => 'X']], []);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(SalesOrderItem::class, $result[0]);
        $this->assertInstanceOf(SubModel::class, $result[0]);
        $this->assertEquals('X', $result[0]->articleId);
        $this->assertEquals('X', $result[0]['articleId']);
    }

    public function test_sub_model_set_returns_plain_arrays(): void
    {
        $cast = SalesOrderItem::castUsing([]);
        $item = new SalesOrderItem(['articleId' => 'X', 'quantity' => '1']);

        $result = $cast->set(new SalesOrder, 'orderItems', [$item], []);

        // Must be wrapped as ['orderItems' => [...]] so Eloquent's
        // normalizeCastClassResponse() stores it under the correct key.
        $this->assertArrayHasKey('orderItems', $result);
        $this->assertIsArray($result['orderItems']);
        $this->assertIsArray($result['orderItems'][0]);
        $this->assertEquals('X', $result['orderItems'][0]['articleId']);
    }

    /**
     * foreach ($item as $key => $value) must iterate over the attributes,
     * exactly like iterating over the plain array it replaces.
     */
    public function test_sub_model_foreach_iteration(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1', 'quantity' => '2', 'positionNumber' => 10]);

        $collected = [];
        foreach ($item as $key => $value) {
            $collected[$key] = $value;
        }

        $this->assertSame(['articleId' => 'A1', 'quantity' => '2', 'positionNumber' => 10], $collected);
    }

    /**
     * count($item) must return the number of attributes, like count() on
     * the plain array it replaces.
     */
    public function test_sub_model_count(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1', 'quantity' => '2', 'positionNumber' => 10]);

        $this->assertSame(3, count($item));
        $this->assertCount(3, $item);
    }

    /**
     * json_encode($item) must produce the same JSON as encoding the plain array
     * it replaces, not an empty object {}.
     */
    public function test_sub_model_json_encode_single_item(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1', 'quantity' => '2']);

        $this->assertSame(json_encode(['articleId' => 'A1', 'quantity' => '2']), json_encode($item));
    }

    /**
     * json_encode() on the parent model must still produce the same JSON as
     * it would have with plain arrays — Eloquent calls toArray() which
     * flattens SubModel instances via Arrayable.
     */
    public function test_sub_model_json_encode_parent_model(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": "1", "orderItems": [{"articleId": "A1", "quantity": "2"}]}]}'
            ));

        $order = SalesOrder::find('1');

        $decoded = json_decode($order->toJson(), true);

        $this->assertIsArray($decoded['orderItems']);
        $this->assertIsArray($decoded['orderItems'][0]);
        $this->assertEquals('A1', $decoded['orderItems'][0]['articleId']);
    }

    /**
     * $order->toArray() must return a nested plain array, not an array of
     * SubModel objects — existing code that calls toArray() for serialisation
     * must continue to work.
     */
    public function test_sub_model_to_array_on_parent_returns_plain_nested_arrays(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": "1", "orderItems": [{"articleId": "A1"}], "recordAddress": {"city": "Berlin"}}]}'
            ));

        $order = SalesOrder::find('1');
        $arr = $order->toArray();

        // List field: outer list and each item must both be plain arrays
        $this->assertIsArray($arr['orderItems']);
        $this->assertIsArray($arr['orderItems'][0]);
        $this->assertEquals('A1', $arr['orderItems'][0]['articleId']);

        // Single-object field: must also be a plain array
        $this->assertIsArray($arr['recordAddress']);
        $this->assertEquals('Berlin', $arr['recordAddress']['city']);
    }

    /**
     * isset($item['key']) must work for both present and absent attributes.
     */
    public function test_sub_model_isset_on_bracket(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1', 'quantity' => null]);

        $this->assertTrue(isset($item['articleId']));
        $this->assertFalse(isset($item['quantity']));   // null → not set
        $this->assertFalse(isset($item['nonExistent']));
    }

    /**
     * Writing via bracket syntax must persist to the SubModel attributes and
     * round-trip correctly through toArray().
     */
    public function test_sub_model_bracket_write(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1']);
        $item['quantity'] = '5';

        $this->assertEquals('5', $item['quantity']);
        $this->assertEquals('5', $item->quantity);
        $this->assertEquals(['articleId' => 'A1', 'quantity' => '5'], $item->toArray());
    }

    /**
     * unset($item['key']) must remove the attribute.
     */
    public function test_sub_model_bracket_unset(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1', 'quantity' => '2']);
        unset($item['quantity']);

        $this->assertFalse(isset($item['quantity']));
        $this->assertArrayNotHasKey('quantity', $item->toArray());
    }

    /**
     * is_array() on a list field still returns true (the outer list is a
     * native PHP array of SubModel instances, not a SubModel itself).
     */
    public function test_sub_model_list_field_is_still_array(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                200,
                [],
                '{"result": [{"id": "1", "orderItems": [{"articleId": "A1"}]}]}'
            ));

        $order = SalesOrder::find('1');

        // The outer list must still be a plain PHP array
        $this->assertIsArray($order->orderItems);
        // The individual item is a SubModel, not a plain array
        $this->assertInstanceOf(SubModel::class, $order->orderItems[0]);
    }

    /**
     * SubModel implements Countable, IteratorAggregate, and JsonSerializable,
     * so all three interfaces can be type-checked when needed.
     */
    public function test_sub_model_implements_extra_interfaces(): void
    {
        $item = new SalesOrderItem([]);

        $this->assertInstanceOf(\Countable::class, $item);
        $this->assertInstanceOf(\IteratorAggregate::class, $item);
        $this->assertInstanceOf(\JsonSerializable::class, $item);
    }

    /**
     * SubModel::toArray() on the sub-model itself returns the raw attributes.
     */
    public function test_sub_model_to_array_on_sub_model_itself(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1', 'quantity' => '3']);

        $this->assertSame(['articleId' => 'A1', 'quantity' => '3'], $item->toArray());
    }

    /**
     * Writing via magic property setter (__set) must persist to the attributes.
     */
    public function test_sub_model_magic_set(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1']);
        $item->quantity = '7';

        $this->assertEquals('7', $item->quantity);
        $this->assertEquals('7', $item['quantity']);
    }

    /**
     * isset($item->foo) must return true for present non-null attributes and
     * false for absent or null-valued attributes (__isset).
     */
    public function test_sub_model_magic_isset(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1', 'quantity' => null]);

        $this->assertTrue(isset($item->articleId));
        $this->assertFalse(isset($item->quantity));    // null → not set
        $this->assertFalse(isset($item->nonExistent));
    }

    /**
     * unset($item->foo) must remove the attribute from the SubModel (__unset).
     */
    public function test_sub_model_magic_unset(): void
    {
        $item = new SalesOrderItem(['articleId' => 'A1', 'quantity' => '2']);
        unset($item->quantity);

        $this->assertFalse(isset($item->quantity));
        $this->assertArrayNotHasKey('quantity', $item->toArray());
    }

    /**
     * $item[] = 'value' (append / null-offset) must push the value onto the
     * internal attributes array (offsetSet with null offset).
     */
    public function test_sub_model_offset_set_with_null_offset(): void
    {
        $item = new SalesOrderItem([]);
        $item[] = 'appended';

        $this->assertContains('appended', $item->toArray());
        $this->assertCount(1, $item);
    }

    /**
     * SubModelCast::set() with a null value must still return the key-wrapped
     * form ['orderItems' => null] so Eloquent stores null under the right key.
     */
    public function test_sub_model_cast_set_null_returns_null(): void
    {
        $cast = SalesOrderItem::castUsing([]);

        $result = $cast->set(new SalesOrder, 'orderItems', null, []);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('orderItems', $result);
        $this->assertNull($result['orderItems']);
    }

    /**
     * Regression: when inserting a model that has sub-model list attributes,
     * the sub-model data must appear in the POST body under the correct key.
     *
     * Before the fix, SubModelCast::set() returned a bare PHP array which
     * Eloquent's normalizeCastClassResponse() spread into the attribute bag
     * under the sub-model's own keys, silently dropping the attribute name
     * (e.g. "orderItems") from the inserted payload.
     */
    public function test_sub_model_key_preserved_on_insert(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(
                201,
                [],
                '{"id": "99", "orderItems": [{"articleId": "A1", "quantity": "2"}]}'
            ));

        $order = new SalesOrder;
        $order->orderItems = [new SalesOrderItem(['articleId' => 'A1', 'quantity' => '2'])];
        $order->save();

        // The POST bindings must include the 'orderItems' key with a plain-array value.
        Event::assertDispatched(QueryExecuted::class, function ($event) {
            if (! str_starts_with((string) $event->sql, 'POST:salesOrder')) {
                return false;
            }
            $items = $event->bindings['orderItems'] ?? null;

            return is_array($items) && isset($items[0]) && is_array($items[0])
                && ($items[0]['articleId'] ?? null) === 'A1';
        });
    }
}
