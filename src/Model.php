<?php

namespace Geccomedia\Weclapp;

use Geccomedia\Weclapp\Builder as EloquentBuilder;
use Geccomedia\Weclapp\Query\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class DynamoDbModel.
 */
abstract class Model extends BaseModel
{
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * Always set this to false since DynamoDb does not support incremental Id.
     *
     * @var bool
     */
    public $incrementing = true;

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
     * @var string
     */
    protected $perPage = '100';

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
     * @return EloquentBuilder|static
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
        return new Connection(app(Client::class));
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
     * @param  mixed $value
     * @return \Carbon\Carbon
     */
    protected function asDateTime($value)
    {
        if (is_numeric($value)) {
            $value = round($value / 1000);
        }
        return parent::asDateTime($value);
    }

    /**
     * Convert a DateTime to a storable string.
     *
     * @param  \DateTime|int $value
     * @return string
     */
    public function fromDateTime($value)
    {
        return $value instanceof \DateTime?parent::fromDateTime($value)*1000:parent::fromDateTime($value);
    }

    /**
     * Insert the given attributes and set the ID on the model.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $attributes
     * @return void
     */
    protected function insertAndSetId(\Illuminate\Database\Eloquent\Builder $query, $attributes)
    {
        $this->setRawAttributes($query->insertGetId($attributes), true);
    }
}