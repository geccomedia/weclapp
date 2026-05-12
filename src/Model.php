<?php

namespace Geccomedia\Weclapp;

use Carbon\Carbon;
use Geccomedia\Weclapp\Builder as EloquentBuilder;
use Geccomedia\Weclapp\Query\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Date;

/**
 * @property string|int|null $id
 * @property Carbon|null $createdDate
 * @property Carbon|null $lastModifiedDate
 * @property int $version
 */
abstract class Model extends BaseModel
{
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Uv';

    /**
     * Always set this to false since DynamoDb does not support incremental Id.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Weclapp IDs are strings, not integers.
     *
     * Declaring this explicitly ensures Eloquent's eager-loading picks `whereIn`
     * rather than `whereIntegerInRaw`, which our grammar does not handle.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'createdDate';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'lastModifiedDate';

    /**
     * The page limit of the weclapp resource.
     *
     * @var int
     */
    protected $perPage = 100;

    /**
     * Define a belongs-to relationship.
     *
     * Overrides the Eloquent default to use camelCase foreign keys (e.g. "customerId")
     * instead of snake_case ("customer_id"), matching weclapp's naming convention.
     *
     * @param  class-string<BaseModel>  $related
     * @return BelongsTo
     */
    public function belongsTo($related, $foreignKey = null, $ownerKey = null, $relation = null)
    {
        if (is_null($relation)) {
            $relation = $this->guessBelongsToRelation();
        }

        $instance = $this->newRelatedInstance($related);

        if (is_null($foreignKey)) {
            $foreignKey = lcfirst(class_basename($related)).$instance->getKeyName();
        }

        $ownerKey = $ownerKey ?: $instance->getKeyName();

        return $this->newBelongsTo(
            $instance->newQuery(), $this, $foreignKey, $ownerKey, $relation
        );
    }

    /**
     * Derive the API resource name from the class name: lcfirst(ShortClassName).
     * This means no model subclass needs to declare $table explicitly.
     *
     * @return string
     */
    public function getTable()
    {
        if (isset($this->table)) {
            return $this->table;
        }

        $shortName = (new \ReflectionClass($this))->getShortName();

        return lcfirst($shortName);
    }

    /**
     * Get the table qualified key name.
     *
     * @return string
     */
    public function getQualifiedKeyName()
    {
        return $this->getKeyName();
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  Builder  $query
     * @return EloquentBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new EloquentBuilder($query);
    }

    /**
     * Get the database connection for the model.
     *
     * @return Connection
     */
    // @phpstan-ignore-next-line method.childReturnType
    public function getConnection()
    {
        return app(Connection::class);
    }

    /**
     * Set the connection associated with the model.
     *
     * @param  string|null  $name
     * @return $this
     */
    public function setConnection($name)
    {
        return $this;
    }

    /**
     * Return a timestamp as DateTime object.
     *
     * @param  mixed  $value
     * @return Carbon
     */
    protected function asDateTime($value)
    {
        if (
            $this->getDateFormat() == 'Uv' &&
            is_numeric($value) &&
            Date::hasFormat(substr($value, 0, -3), 'U')
        ) {
            return Date::createFromFormat('U', substr($value, 0, -3))->milli((int) substr($value, -3));
        }

        return parent::asDateTime($value);
    }

    /**
     * Insert the given attributes and set the ID on the model.
     *
     * @param  array  $attributes
     * @return void
     */
    protected function insertAndSetId(\Illuminate\Database\Eloquent\Builder $query, $attributes)
    {
        $this->setRawAttributes((array) $query->insertGetId($attributes), true);
    }

    /**
     * Convert the model's attributes to an array.
     *
     * Extends the Eloquent default to recursively flatten any SubModel
     * instances that remain in list-type cast attributes.  This ensures that
     * `$model->toArray()` and `$model->toJson()` always return plain nested
     * arrays, matching the pre-SubModel behaviour.
     *
     * @return array<string, mixed>
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach ($attributes as $key => $value) {
            $attributes[$key] = $this->flattenSubModels($value);
        }

        return $attributes;
    }

    /**
     * Recursively convert any SubModel instances (or arrays containing them)
     * into plain arrays.
     */
    private function flattenSubModels(mixed $value): mixed
    {
        if ($value instanceof SubModel) {
            return $value->toArray();
        }

        if (is_array($value)) {
            return array_map(fn (mixed $item) => $this->flattenSubModels($item), $value);
        }

        return $value;
    }
}
