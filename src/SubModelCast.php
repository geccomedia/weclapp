<?php

namespace Geccomedia\Weclapp;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * Caster for SubModel properties.
 *
 * Registered automatically via SubModel::castUsing(), so every SubModel
 * subclass is usable directly in $casts without any additional plumbing:
 *
 *   protected $casts = [
 *       'orderItems'    => SalesOrderItem::class,   // list  — auto-detected
 *       'recordAddress' => RecordAddress::class,    // single — auto-detected
 *   ];
 *
 * List vs single is determined at runtime from the raw value shape:
 *   - a list-of-arrays  → hydrated as array<SubModel>
 *   - an associative array → hydrated as a single SubModel
 *
 * Backwards compatibility guarantee
 * ----------------------------------
 * SubModel implements ArrayAccess, so all existing code that accesses
 * embedded data as plain arrays ($order->orderItems[0]['articleId'])
 * continues to work without modification.
 *
 * @template T of SubModel
 *
 * @implements CastsAttributes<T|list<T>|null, array<string,mixed>|list<array<string,mixed>>|null>
 */
class SubModelCast implements CastsAttributes
{
    /**
     * @param  class-string<T>  $subModelClass
     */
    public function __construct(private readonly string $subModelClass) {}

    /**
     * Hydrate the raw API value into SubModel instance(s).
     *
     * @param  array<string,mixed>|list<array<string,mixed>>|null  $value
     * @return T|list<T>|null
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null) {
            return null;
        }

        $class = $this->subModelClass;

        if (array_is_list((array) $value)) {
            return array_map(static fn (array $item) => new $class($item), (array) $value);
        }

        return new $class((array) $value);
    }

    /**
     * Serialise SubModel instance(s) back to plain arrays so that
     * $model->getAttributes() always contains raw arrays — keeping all
     * existing PUT / POST serialisation completely unchanged.
     *
     * @param  T|list<T>|array<string,mixed>|list<array<string,mixed>>|null  $value
     * @return array<string,mixed>|list<array<string,mixed>>|null
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null) {
            return null;
        }

        if (array_is_list((array) $value)) {
            return array_map(
                static fn (mixed $item) => $item instanceof SubModel ? $item->toArray() : (array) $item,
                (array) $value,
            );
        }

        return $value instanceof SubModel ? $value->toArray() : (array) $value;
    }
}
