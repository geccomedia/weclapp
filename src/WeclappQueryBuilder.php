<?php

namespace Geccomedia\Weclapp;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use function in_array;

class WeclappQueryBuilder extends Builder
{
    /**
     * The maximum number of records to return.
     *
     * @var int
     */
    protected $limit;

    /**
     * The number of records to skip.
     *
     * @var int
     */
    protected $offset;

    /**
     * @var array
     */
    protected $selects = [];

    /**
     * @var array
     */
    protected $wheres = [];

    /**
     * @var array
     */
    protected $orders = [];

    /**
     * @var WeclappModel
     */
    protected $model;

    /**
     * Applied global scopes.
     *
     * @var array
     */
    protected $scopes = [];

    /**
     * @var \Guzzle\Http\Client
     */
    protected $client;

    /**
     * Removed global scopes.
     *
     * @var array
     */
    protected $removedScopes = [];

    public function __construct(WeclappBaseQueryBuilder $builder)
    {
        $this->client = new Client([
            'base_uri' => config('accounting.weclapp.base_url'),
            'headers' => [
                'AuthenticationToken' => config('accounting.weclapp.api_key')
            ]
        ]);
        parent::__construct($builder);
    }

    /**
     * Alias to set the "limit" value of the query.
     *
     * @param  int  $value
     * @return DynamoDbQueryBuilder\static
     */
    public function take($value)
    {
        return $this->limit($value);
    }

    /**
     * Set the "limit" value of the query.
     *
     * @param  int  $value
     * @return $this
     */
    public function limit($value)
    {
        $this->limit = $value;

        return $this;
    }

    /**
     * Alias to set the "offset" value of the query.
     *
     * @param  int  $value
     * @return DynamoDbQueryBuilder\static
     */
    public function skip($value)
    {
        return $this->offset($value);
    }

    /**
     * Set the "offset" value of the query.
     *
     * @param  int  $value
     * @return $this
     */
    public function offset($value)
    {
        $this->offset = $value;

        return $this;
    }

    /**
     * @param array|\Closure|string $column
     * @param null $operator
     * @param null $value
     * @param string $boolean
     * @return $this|WeclappQueryBuilder
     * @throws NotSupportedException
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        if($boolean != 'and') {
            throw new NotSupportedException('Weclapp only supports "and"');
        }
        // If the column is an array, we will assume it is an array of key-value pairs
        // and can add them each as a where clause. We will maintain the boolean we
        // received when the method was called and pass it into the nested where.
        if (is_array($column)) {
            foreach ($column as $key => $value) {
                return $this->where($key, '=', $value);
            }
        }

        // Here we will make some assumptions about the operator. If only 2 values are
        // passed to the method, we will assume that the operator is an equals sign
        // and keep going. Otherwise, we'll require the operator to be passed in.
        if (func_num_args() == 2) {
            list($value, $operator) = [$operator, '='];
        }

        // If the given operator is not found in the list of valid operators we will
        // assume that the developer is just short-cutting the '=' operators and
        // we will set the operators to '=' and set the values appropriately.
        if (!ComparisonOperator::isValidOperator($operator)) {
            list($value, $operator) = [$operator, '='];
        }

        // If the value is a Closure, it means the developer is performing an entire
        // sub-select within the query and we will need to compile the sub-select
        // within the where clause to get the appropriate query record results.
        if ($value instanceof \Closure) {
            throw new NotSupportedException('Closure in where clause is not supported');
        }

        $this->wheres[] = [
            'column' => $column,
            'type' => ComparisonOperator::getWeclappOperator($operator),
            'value' => $value,
        ];

        return $this;
    }

    /**
     * Add a "where in" clause to the query.
     *
     * @param  string  $column
     * @param  mixed   $values
     * @param  bool    $not
     * @return $this
     * @throws NotSupportedException
     */
    public function whereIn($column, $values, $not = false)
    {
        // If the value is a query builder instance, not supported
        if ($values instanceof static) {
            throw new NotSupportedException('Closure in where clause is not supported');
        }

        // If the value of the where in clause is actually a Closure, not supported
        if ($values instanceof \Closure) {
            throw new NotSupportedException('Value is a Closure');
        }

        // Next, if the value is Arrayable we need to cast it to its raw array form
        if ($values instanceof Arrayable) {
            $values = $values->toArray();
        }

        return $this->where($column, $not?'not_in':'in', $values);
    }

    /**
     * Add a "where null" clause to the query.
     *
     * @param  string  $column
     * @param  bool    $not
     * @return $this
     */
    public function whereNull($column, $not = false)
    {
        $type = $not ? ComparisonOperator::NOT_NULL : ComparisonOperator::NULL;

        $this->wheres[] = compact('column', 'type');

        return $this;
    }

    /**
     * Add a "where not null" clause to the query.
     *
     * @param  string  $column
     * @return $this
     */
    public function whereNotNull($column)
    {
        return $this->whereNull($column, true);
    }


    /**
     * Add a where clause on the primary key to the query.
     *
     * @param  mixed  $id
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
     * Add an "order by" clause to the query.
     *
     * @param  string  $column
     * @param  string  $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->orders[] = [
            'column' => $column,
            'direction' => strtolower($direction) == 'asc' ? 'asc' : 'desc',
        ];

        return $this;
    }

    public function select($columns = [])
    {
        $this->selects = array_merge($this->selects, $columns);

        return $this;
    }

    /**
     * Get a new instance of the query builder.
     *
     * @return WeclappQueryBuilder
     */
    public function newQuery()
    {
        return new static($this->getModel());
    }

    /**
     * Implements the Query Chunk method
     *
     * @param int $chunk_size
     * @param callable $callback
     */
    public function chunk($chunk_size, callable $callback)
    {
        $page = 1;
        while (true) {
            try{
                $results = $this->skip($page*$chunk_size)
                    ->getAll([], $chunk_size);
                $page++;

                call_user_func($callback, $results);
            }
            catch (ModelNotFoundException $e){
                break;
            }
        }
    }

    public function find($id, $columns = [])
    {
        if (is_array($id)) {
            return $this->findMany($id, $columns);
        }

        $response = $this->client->get($this->model->getTable().'/id/'.$id);

        $item = json_decode($response->getBody(), true);

        if (empty($item)) {
            return null;
        }

        return $this->model->newInstance([], true)
            ->setRawAttributes($item, true);
    }

    public function findMany($ids, $columns = [])
    {
        return $this->whereKey($ids)
            ->getAll($columns);
    }

    public function first($columns = [])
    {
        return $this->getAll($columns, 1)
            ->first();
    }

    public function firstOrFail($columns = [])
    {
        if (! is_null($model = $this->first($columns))) {
            return $model;
        }

        throw (new ModelNotFoundException)->setModel(get_class($this->model));
    }

    public function get($columns = [])
    {
        return $this->getAll($columns);
    }

    protected function getAll($columns, $limit = -1)
    {
        if($limit != -1){
            $this->limit($limit);
        }
        if(count($columns) > 0){
            $this->select($columns);
        }
        $query = $this->buildQuery();

        $queryString = $this->model->getTable().'?'.$query;

        $response = $this->client->get($queryString);
        $items = json_decode($response->getBody(), true);

        if(!isset($items['result']) || count($items['result']) == 0){
            throw new ModelNotFoundException();
        }

        $results = [];

        foreach ($items['result'] as $item) {
            $results[] = $this->model->newInstance([], true)
                ->setRawAttributes($item, true);
        }
        return $this->getModel()->newCollection($results);
    }

    protected function buildQuery()
    {
        $query = [];

        if(count($this->wheres) > 0){
            foreach ($this->wheres as $where){
                $value = is_array($where['value']) ? json_encode($where['value']) : $where['value'];
                $key = $where['column'] . '-' . $where['type'];
                $query[$key] = $value;
            }
        }

        if($this->limit > 0){
            $query['pageSize'] = (int)$this->limit;
        }

        if($this->offset > 0){
            $limit = $this->limit ?: $this->model->getPerPage();
            $page = $this->offset / $limit + 1;
            $query['page'] = (int)$page;
        }

        if(count($this->orders) > 0){
            $orders = [];
            foreach ($this->orders as $order){
                $orders[] = ($order['direction'] == 'desc'?'-':'').$order['column'];
            }
            $query['sort'] = implode(',', $orders);
        }

        if(count($this->selects) > 0 && !(count($this->selects) == 1 && in_array('*', $this->selects))){
            $query['properties'] = implode(',', $this->selects);
        }

        return http_build_query($query, null, '&', PHP_QUERY_RFC3986);
    }

    public function delete()
    {
        $queryString = $this->model->getTable().'/id/'.$this->model->{$this->model->getKeyName()};

        $response = $this->client->delete($queryString);

        return $response->getStatusCode() == 204;
    }

    /**
     * Insert a new record into the database.
     *
     * @param  array  $values
     * @return bool
     * @throws NotSupportedException
     */
    public function insert(array $values)
    {
        // Since every insert gets treated like a batch insert, we will make sure the
        // bindings are structured in a way that is convenient when building these
        // inserts statements by verifying these elements are actually an array.
        if (empty($values)) {
            return true;
        }

        if (! is_array(reset($values))) {
            $values = [$values];
        }

        // Here, we will sort the insert keys for every record so that each insert is
        // in the same order for the record. We need to make sure this is the case
        // so there are not any errors or problems when inserting these records.
        else {
            throw new NotSupportedException('Batch insert is not supported by Weclapp');
        }

        $values = (object) $values;

        $queryString = $this->model->getTable();

        $response = $this->client->post($queryString, [
            RequestOptions::JSON => $values
        ]);
        $item = json_decode($response->getBody(), true);

        $this->model->setRawAttributes($item, true);

        return $response->getStatusCode() == 201;
    }

    public function all($columns = [])
    {
        return $this->getAll($columns);
    }

    public function count($columns = [])
    {
        $query = $this->buildQuery();

        $queryString = $this->model->getTable().'/count?'.$query;

        $response = $this->client->get($queryString);
        $items = json_decode($response->getBody(), true);

        return (int) $items['result'];
    }

    /**
     * @return \Geccomedia\Weclapp\WeclappModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return \Guzzle\Http\Client
     */
    public function getClient()
    {
        return $this->client;
    }


    /**
     * Insert a new record and get the value of the primary key.
     *
     * @param  array   $values
     * @param  string  $sequence
     * @return int
     */
    public function insertGetId(array $values, $sequence = null)
    {
        $values = (object) $values;

        $queryString = $this->model->getTable();

        $response = $this->client->post($queryString, [
            RequestOptions::JSON => $values
        ]);
        $item = json_decode($response->getBody(), true);

        $this->model->setRawAttributes($item, true);

        return $item[$this->model->getKeyName()];
    }


    /**
     * Update a record in the database.
     *
     * @param  array  $values
     * @return int
     */
    public function update(array $values)
    {
        $queryString = $this->model->getTable().'/id/'.$this->model->{$this->model->getKeyName()};

        $response = $this->client->put($queryString, [
            RequestOptions::JSON => $this->model->getAttributes()
        ]);
        $item = json_decode($response->getBody(), true);

        $this->model->setRawAttributes($item, true);

        return $item['version'] != $this->model->version;
    }


    /**
     * Create a new instance of the model being queried.
     *
     * @param  array  $attributes
     * @return WeclappModel|static
     */
    public function newModelInstance($attributes = [])
    {
        return $this->model->newInstance($attributes);
    }
}
