<?php

namespace Geccomedia\Weclapp;

use Geccomedia\Weclapp\SubModels\OnlyId;
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
     * The return value MUST be wrapped as [$key => $serialised] rather than
     * a bare array.  Eloquent's normalizeCastClassResponse() does:
     *
     *     is_array($value) ? $value : [$key => $value]
     *
     * A bare array is therefore spread directly into the model's attribute bag
     * under its *own* keys, silently dropping the attribute name (e.g.
     * "orderItems") and losing all sub-model data on insert.
     *
     * @param  T|list<T>|array<string,mixed>|list<array<string,mixed>>|null  $value
     * @return array<string, array<string,mixed>|list<array<string,mixed>>|null>
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if ($value === null) {
            return [$key => null];
        }

        if (array_is_list((array) $value)) {
            return [$key => array_map(
                fn (mixed $item) => $this->normalise($item),
                (array) $value,
            )];
        }

        return [$key => $this->normalise($value)];
    }

    /**
     * Coerce a single item to a plain array suitable for the API payload.
     *
     * When the target cast is OnlyId and the supplied value is a full Model
     * instance, only the primary key is extracted — i.e. the model is
     * automatically reduced to ["id" => $model->id] so callers can pass
     * relationship models directly without manually wrapping them:
     *
     *   $customer->contacts = [$contact, $otherContact];
     *   // serialises as [{"id": "1"}, {"id": "2"}] — no extra wrapping needed
     *
     * @return array<string, mixed>
     */
    private function normalise(mixed $item): array
    {
        if ($item instanceof SubModel) {
            return $item->toArray();
        }

        if ($this->subModelClass === OnlyId::class && $item instanceof Model) {
            return ['id' => $item->getKey()];
        }

        return (array) $item;
    }
}
