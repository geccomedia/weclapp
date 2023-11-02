<?php

namespace Geccomedia\Weclapp;

use Geccomedia\Weclapp\Models\ArchivedEmail;
use Geccomedia\Weclapp\Models\Comment;
use Geccomedia\Weclapp\Models\Document;
use Geccomedia\Weclapp\Query\Builder as QueryBuilder;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder as BaseBuilder;
use Illuminate\Database\Eloquent\Model;

class Builder extends BaseBuilder
{
    /**
     * List of models that the weclapp api does handle in a special way.
     * See https://github.com/geccomedia/weclapp/issues/22
     *
     * @var array
     */
    protected array $entityModels = [
        ArchivedEmail::class,
        Comment::class,
        Document::class,
    ];

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
     * Used to query for special models that belong to entities and are handled different on weclapp api.
     * See https://github.com/geccomedia/weclapp/issues/22
     *
     * @param string $name
     * @param int $id
     * @throws NotSupportedException
     */
    public function whereEntity(string $name, int $id)
    {
        if (!in_array(get_class($this->model), $this->entityModels)) {
            throw new NotSupportedException('whereEntity are only not supported on ' . get_class($this->model) . ' by weclapp');
        }

        $this->query->wheres[] = ['type' => 'Entity', 'column' => 'entityName', 'value' => $name];
        $this->query->wheres[] = ['type' => 'Entity', 'column' => 'entityId', 'value' => $id];

        return $this;
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
