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
 *
 * -------------------------------------------------------------------------
 * Weclapp-specific builder methods (forwarded via __callStatic / __call)
 * -------------------------------------------------------------------------
 *
 * @method static \Geccomedia\Weclapp\Builder<static> whereEntity(string $name, int $id)
 * @method static \Geccomedia\Weclapp\Builder<static> withProperties(string|array ...$properties)
 * @method static array<mixed>|null action(string $action, array $params = [], string $method = 'POST')
 *
 * -------------------------------------------------------------------------
 * Query entry points
 * -------------------------------------------------------------------------
 * @method static \Geccomedia\Weclapp\Builder<static> query()
 * @method static \Geccomedia\Weclapp\Builder<static> on(string|null $connection = null)
 * @method static \Geccomedia\Weclapp\Builder<static> onWriteConnection()
 *
 * -------------------------------------------------------------------------
 * Constraints — WHERE clauses
 * -------------------------------------------------------------------------
 * @method static \Geccomedia\Weclapp\Builder<static> where(\Closure|string|array $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static \Geccomedia\Weclapp\Builder<static> orWhere(\Closure|string|array $column, mixed $operator = null, mixed $value = null)
 * @method static \Geccomedia\Weclapp\Builder<static> whereNot(\Closure|string|array $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static \Geccomedia\Weclapp\Builder<static> orWhereNot(\Closure|string|array $column, mixed $operator = null, mixed $value = null)
 * @method static \Geccomedia\Weclapp\Builder<static> whereKey(mixed $id)
 * @method static \Geccomedia\Weclapp\Builder<static> whereKeyNot(mixed $id)
 * @method static \Geccomedia\Weclapp\Builder<static> whereIn(string $column, mixed $values, string $boolean = 'and', bool $not = false)
 * @method static \Geccomedia\Weclapp\Builder<static> orWhereIn(string $column, mixed $values)
 * @method static \Geccomedia\Weclapp\Builder<static> whereNotIn(string $column, mixed $values, string $boolean = 'and')
 * @method static \Geccomedia\Weclapp\Builder<static> orWhereNotIn(string $column, mixed $values)
 * @method static \Geccomedia\Weclapp\Builder<static> whereNull(string|array $columns, string $boolean = 'and', bool $not = false)
 * @method static \Geccomedia\Weclapp\Builder<static> orWhereNull(string $column)
 * @method static \Geccomedia\Weclapp\Builder<static> whereNotNull(string|array $columns, string $boolean = 'and')
 * @method static \Geccomedia\Weclapp\Builder<static> orWhereNotNull(string $column)
 * @method static \Geccomedia\Weclapp\Builder<static> whereBetween(string $column, iterable $values, string $boolean = 'and', bool $not = false)
 * @method static \Geccomedia\Weclapp\Builder<static> orWhereBetween(string $column, iterable $values)
 * @method static \Geccomedia\Weclapp\Builder<static> whereNotBetween(string $column, iterable $values, string $boolean = 'and')
 * @method static \Geccomedia\Weclapp\Builder<static> orWhereNotBetween(string $column, iterable $values)
 * @method static \Geccomedia\Weclapp\Builder<static> whereDate(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method static \Geccomedia\Weclapp\Builder<static> whereMonth(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method static \Geccomedia\Weclapp\Builder<static> whereDay(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method static \Geccomedia\Weclapp\Builder<static> whereYear(string $column, string $operator, \DateTimeInterface|string|int|null $value = null, string $boolean = 'and')
 * @method static \Geccomedia\Weclapp\Builder<static> whereTime(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method static \Geccomedia\Weclapp\Builder<static> whereLike(string $column, string $value, bool $caseSensitive = false, string $boolean = 'and', bool $not = false)
 * @method static \Geccomedia\Weclapp\Builder<static> orWhereLike(string $column, string $value, bool $caseSensitive = false)
 * @method static \Geccomedia\Weclapp\Builder<static> whereNotLike(string $column, string $value, bool $caseSensitive = false, string $boolean = 'and')
 *
 * -------------------------------------------------------------------------
 * Ordering, grouping, limiting
 * -------------------------------------------------------------------------
 * @method static \Geccomedia\Weclapp\Builder<static> orderBy(string $column, string $direction = 'asc')
 * @method static \Geccomedia\Weclapp\Builder<static> orderByDesc(string $column)
 * @method static \Geccomedia\Weclapp\Builder<static> latest(string|null $column = null)
 * @method static \Geccomedia\Weclapp\Builder<static> oldest(string|null $column = null)
 * @method static \Geccomedia\Weclapp\Builder<static> skip(int $value)
 * @method static \Geccomedia\Weclapp\Builder<static> offset(int $value)
 * @method static \Geccomedia\Weclapp\Builder<static> take(int $value)
 * @method static \Geccomedia\Weclapp\Builder<static> limit(int $value)
 * @method static \Geccomedia\Weclapp\Builder<static> forPage(int $page, int $perPage = 15)
 *
 * -------------------------------------------------------------------------
 * Column selection
 * -------------------------------------------------------------------------
 * @method static \Geccomedia\Weclapp\Builder<static> select(array|string $columns = ['*'])
 * @method static \Geccomedia\Weclapp\Builder<static> addSelect(array|string $column)
 *
 * -------------------------------------------------------------------------
 * Eager loading
 * -------------------------------------------------------------------------
 * @method static \Geccomedia\Weclapp\Builder<static> with(array|string $relations, \Closure|string|null $callback = null)
 * @method static \Geccomedia\Weclapp\Builder<static> without(array|string $relations)
 * @method static \Geccomedia\Weclapp\Builder<static> withOnly(array|string $relations)
 *
 * -------------------------------------------------------------------------
 * Retrieval — single model
 * -------------------------------------------------------------------------
 * @method static static|null find(mixed $id, array $columns = ['*'])
 * @method static static findOrFail(mixed $id, array $columns = ['*'])
 * @method static static findOrNew(mixed $id, array $columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Collection<int,static> findMany(\Illuminate\Contracts\Support\Arrayable<array-key,mixed>|array $ids, array $columns = ['*'])
 * @method static static|null first(array $columns = ['*'])
 * @method static static firstOrFail(array $columns = ['*'])
 * @method static static firstOrNew(array $attributes = [], array $values = [])
 * @method static static firstOrCreate(array $attributes = [], array $values = [])
 * @method static static|null firstWhere(\Closure|string|array $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static static updateOrCreate(array $attributes, array $values = [])
 * @method static static sole(array $columns = ['*'])
 *
 * -------------------------------------------------------------------------
 * Retrieval — collections
 * -------------------------------------------------------------------------
 * @method static \Illuminate\Database\Eloquent\Collection<int,static> get(array $columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Collection<int,static> all(array $columns = ['*'])
 *
 * -------------------------------------------------------------------------
 * Aggregates
 * -------------------------------------------------------------------------
 * @method static int count(string $columns = '*')
 * @method static float|int min(string $column)
 * @method static float|int max(string $column)
 * @method static float|int sum(string $column)
 * @method static float|int avg(string $column)
 * @method static float|int average(string $column)
 * @method static bool exists()
 * @method static bool doesntExist()
 *
 * -------------------------------------------------------------------------
 * Chunking / lazy iteration
 * -------------------------------------------------------------------------
 * @method static bool chunk(int $count, callable $callback)
 * @method static bool chunkById(int $count, callable $callback, string|null $column = null, string|null $alias = null)
 * @method static \Illuminate\Support\LazyCollection<int,static> lazy(int $chunkSize = 1000)
 * @method static \Illuminate\Support\LazyCollection<int,static> lazyById(int $chunkSize = 1000, string|null $column = null, string|null $alias = null)
 * @method static \Illuminate\Support\LazyCollection<int,static> cursor()
 *
 * -------------------------------------------------------------------------
 * Plucking / value extraction
 * -------------------------------------------------------------------------
 * @method static \Illuminate\Support\Collection<array-key,mixed> pluck(string $column, string|null $key = null)
 * @method static mixed value(string $column)
 *
 * -------------------------------------------------------------------------
 * Pagination
 * -------------------------------------------------------------------------
 * @method static \Illuminate\Pagination\LengthAwarePaginator<int,static> paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
 * @method static \Illuminate\Pagination\Paginator<int,static> simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
 * @method static \Illuminate\Pagination\CursorPaginator<int,static> cursorPaginate(int|null $perPage = null, array $columns = ['*'], string $cursorName = 'cursor', \Illuminate\Pagination\Cursor|string|null $cursor = null)
 *
 * -------------------------------------------------------------------------
 * Persistence
 * -------------------------------------------------------------------------
 * @method static static create(array $attributes = [])
 * @method static static forceCreate(array $attributes)
 * @method static int insert(array $values)
 * @method static int delete()
 * @method static int update(array $values)
 * @method static int increment(string $column, float|int $amount = 1, array $extra = [])
 * @method static int decrement(string $column, float|int $amount = 1, array $extra = [])
 *
 * -------------------------------------------------------------------------
 * Scopes
 * -------------------------------------------------------------------------
 * @method static \Geccomedia\Weclapp\Builder<static> withGlobalScope(string $identifier, \Illuminate\Database\Eloquent\Scope|\Closure $scope)
 * @method static \Geccomedia\Weclapp\Builder<static> withoutGlobalScope(\Illuminate\Database\Eloquent\Scope|string $scope)
 * @method static \Geccomedia\Weclapp\Builder<static> withoutGlobalScopes(array|null $scopes = null)
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
     * Call a custom action endpoint, routing to the collection or instance
     * endpoint depending on whether this model has been persisted.
     *
     * When called on a fresh (unsaved) instance — or via a static call forwarded
     * through Eloquent's __callStatic magic — `$this->exists` is false, so the
     * request goes to the collection-level path:
     *
     *   POST /document/copy
     *
     * When called on a retrieved instance (`$this->exists === true`), the
     * request goes to the instance-level path:
     *
     *   POST /document/id/123/copy
     *
     * This means every action method on a model can be declared as a plain
     * (non-static) method and works correctly in both calling contexts:
     *
     *   Document::copy($params)          // collection — POST /document/copy
     *   $doc->copy($params)              // instance   — POST /document/id/123/copy
     *
     * @param  array<mixed>  $params  POST body or GET query parameters.
     * @return array<mixed>|null
     */
    public function callAction(string $action, array $params = [], string $method = 'POST'): ?array
    {
        $builder = $this->newQuery();

        return $this->exists
            ? $builder->callAction($action, $params, $method)
            : $builder->action($action, $params, $method);
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
