<?php

namespace Geccomedia\Weclapp;

use Geccomedia\Weclapp\Models\ArchivedEmail;
use Geccomedia\Weclapp\Models\Comment;
use Geccomedia\Weclapp\Models\Document;
use Geccomedia\Weclapp\Query\Builder as QueryBuilder;
use Geccomedia\Weclapp\Query\Grammars\Grammar;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder as BaseBuilder;
use Illuminate\Database\Eloquent\Model;

class Builder extends BaseBuilder
{
    /**
     * List of models that the weclapp api does handle in a special way.
     * See https://github.com/geccomedia/weclapp/issues/22
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
     * @param  mixed  $id
     * @return static
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
     * @throws NotSupportedException
     */
    public function whereEntity(string $name, int $id)
    {
        if (! in_array(get_class($this->model), $this->entityModels)) {
            throw new NotSupportedException('whereEntity are only not supported on '.get_class($this->model).' by weclapp');
        }

        $this->query->wheres[] = ['type' => 'Entity', 'column' => 'entityName', 'value' => $name];
        $this->query->wheres[] = ['type' => 'Entity', 'column' => 'entityId', 'value' => $id];

        return $this;
    }

    /**
     * Request extra computed fields via the `additionalProperties` query parameter.
     *
     * @param  string|array<string>  ...$properties
     */
    public function withProperties(string|array ...$properties): static
    {
        $flat = array_merge(...array_map(
            fn ($p) => is_array($p) ? $p : [$p],
            $properties
        ));

        /** @var QueryBuilder $query */
        $query = $this->query;
        $query->additionalProperties = array_merge(
            $query->additionalProperties ?? [],
            $flat
        );

        return $this;
    }

    /**
     * Call a collection-level custom action endpoint.
     *
     * @param  array<mixed>  $params  For POST: JSON body. For GET: query parameters.
     * @return array<mixed>|null
     */
    public function action(string $action, array $params = [], string $method = 'POST'): ?array
    {
        /** @var QueryBuilder $query */
        $query = $this->query;
        /** @var Grammar $grammar */
        $grammar = $query->grammar;
        $request = $grammar->compileAction($query, $action, $params, null, $method);

        return app(Connection::class)->action($request);
    }

    /**
     * Call an instance-level custom action endpoint on an existing record.
     *
     * @param  array<mixed>  $params  For POST: JSON body. For GET: query parameters.
     * @return array<mixed>|null
     */
    public function callAction(string $action, array $params = [], string $method = 'POST'): ?array
    {
        $id = (string) $this->model->getKey();

        /** @var QueryBuilder $query */
        $query = $this->query;
        /** @var Grammar $grammar */
        $grammar = $query->grammar;
        $request = $grammar->compileAction($query, $action, $params, $id, $method);

        return app(Connection::class)->action($request);
    }

    /**
     * Update a record in the database.
     *
     * @return int
     */
    public function update(array $values)
    {
        return parent::update($this->model->getAttributes());
    }
}
