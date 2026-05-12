<?php

namespace Geccomedia\Weclapp;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Support\Arrayable;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

/**
 * Base class for all Weclapp sub-model value objects.
 *
 * Backwards compatibility guarantee
 * ----------------------------------
 * Code that treated embedded API objects as plain PHP arrays continues to work
 * without any changes:
 *
 *   // All of the following work exactly as before:
 *   $order->orderItems[0]['articleId']          // bracket read   (ArrayAccess)
 *   $order->orderItems[0]['articleId'] = 'X'   // bracket write  (ArrayAccess)
 *   isset($order->orderItems[0]['articleId'])   // isset          (ArrayAccess)
 *   unset($order->orderItems[0]['articleId'])   // unset          (ArrayAccess)
 *   foreach ($order->orderItems[0] as $k => $v) // iteration     (IteratorAggregate)
 *   count($order->orderItems[0])               // count          (Countable)
 *   json_encode($order->orderItems[0])         // JSON encoding  (JsonSerializable)
 *   $order->toArray()                          // parent toArray (Arrayable)
 *   $order->toJson()                           // parent toJson  (Arrayable → Eloquent)
 *
 * Known limitations (impossible to transparently replicate for objects):
 *   - `is_array($item)` will return false  — use `$item instanceof SubModel` instead
 *   - `array_key_exists('k', $item)` throws TypeError in PHP 8+ — use `isset($item['k'])`
 *   - `array_merge([...], $item)` throws TypeError in PHP 8+    — use `array_merge([...], $item->toArray())`
 *
 * @implements ArrayAccess<string, mixed>
 * @implements Arrayable<string, mixed>
 * @implements IteratorAggregate<string, mixed>
 */
class SubModel implements Arrayable, ArrayAccess, Castable, Countable, IteratorAggregate, JsonSerializable
{
    /**
     * The raw attribute data from the API response.
     *
     * @var array<string, mixed>
     */
    protected array $attributes;

    /**
     * Return the caster to use when this class appears in a model's $casts.
     *
     * Because SubModel::castUsing() receives the concrete subclass as the
     * late-static context, the returned SubModelCast already knows which
     * class to instantiate — no arguments needed.
     *
     * @param  array<mixed>  $arguments  unused
     */
    public static function castUsing(array $arguments): SubModelCast
    {
        return new SubModelCast(static::class);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    // -------------------------------------------------------------------------
    // Property access
    // -------------------------------------------------------------------------

    public function __get(string $key): mixed
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set(string $key, mixed $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function __isset(string $key): bool
    {
        return isset($this->attributes[$key]);
    }

    public function __unset(string $key): void
    {
        unset($this->attributes[$key]);
    }

    // -------------------------------------------------------------------------
    // ArrayAccess — backwards compat with $obj['key'] access
    // -------------------------------------------------------------------------

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->attributes[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === null) {
            $this->attributes[] = $value;
        } else {
            $this->attributes[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->attributes[$offset]);
    }

    // -------------------------------------------------------------------------
    // Countable — backwards compat with count($obj)
    // -------------------------------------------------------------------------

    /**
     * Returns the number of attributes, matching the behaviour of count() on
     * the plain array that this object replaces.
     */
    public function count(): int
    {
        return count($this->attributes);
    }

    // -------------------------------------------------------------------------
    // IteratorAggregate — backwards compat with foreach ($obj as $k => $v)
    // -------------------------------------------------------------------------

    /**
     * Allow `foreach` iteration over the attributes, exactly as iterating over
     * the plain array that this object replaces.
     *
     * @return ArrayIterator<string, mixed>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->attributes);
    }

    // -------------------------------------------------------------------------
    // JsonSerializable — backwards compat with json_encode($obj)
    // -------------------------------------------------------------------------

    /**
     * Return the raw attributes so that `json_encode($subModel)` produces the
     * same JSON as `json_encode($plainArray)` would have before SubModel was
     * introduced.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): mixed
    {
        return $this->attributes;
    }

    // -------------------------------------------------------------------------
    // Arrayable — serialisation back to plain arrays for API writes
    // -------------------------------------------------------------------------

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->attributes;
    }
}
