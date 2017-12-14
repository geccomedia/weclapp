<?php

namespace Geccomedia\Weclapp;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DynamoDbModel.
 */
abstract class WeclappModel extends Model
{
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
     * Get a new query builder that doesn't have any global scopes.
     *
     * @return \Geccomedia\Weclapp\WeclappQueryBuilder|static
     */
    public function newQueryWithoutScopes()
    {
        $builder = new WeclappQueryBuilder(new WeclappBaseQueryBuilder());

        // Once we have the query builders, we will set the model instances so the
        // builder can easily access any information it may need from the model
        // while it is constructing and executing various queries against it.
        return $builder->setModel($this);
    }
}