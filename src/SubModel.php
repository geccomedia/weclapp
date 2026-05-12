<?php

namespace Geccomedia\Weclapp;

use ArrayAccess;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Base class for all Weclapp sub-model value objects.
 *
 * Implements ArrayAccess so that all existing code that treats embedded
 * API objects as plain PHP arrays (e.g. $order->orderItems[0]['articleId'])
 * continues to work without any changes.
 *
 * @implements ArrayAccess<string, mixed>
 * @implements Arrayable<string, mixed>
 */
class SubModel implements Arrayable, ArrayAccess, Castable
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
