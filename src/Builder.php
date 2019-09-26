<?php

namespace Geccomedia\Weclapp;

use Geccomedia\Weclapp\Query\Builder as QueryBuilder;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder as BaseBuilder;
use Illuminate\Database\Eloquent\Model;

class Builder extends BaseBuilder
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param QueryBuilder $builder
     */
    public function __construct(QueryBuilder $builder)
    {
        parent::__construct($builder);

        $this->client = app(Client::class);
    }

    public function setModel(Model $model)
    {
        $return = parent::setModel($model);
        $this->query->limit = $this->model->getPerPage();
        return $return;
    }

    /**
     * Add a where clause on the primary key to the query.
     *
     * @param  mixed $id
     * @return $this
     */
    public function whereKey($id)
    {
        if (is_array($id) || $id instanceof Arrayable) {
            $this->whereIn($this->model->getQualifiedKeyName(), $id);

            return $this;
        }

        return $this->where($this->model->getQualifiedKeyName(), '=', $id);
    }

    /**
     * Update a record in the database.
     *
     * @param  array  $values
     * @return int
     */
    public function update(array $values)
    {
        return parent::update($this->model->getAttributes());
    }
}
