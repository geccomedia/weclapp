<?php

namespace Geccomedia\Weclapp;

use Closure;
use Geccomedia\Weclapp\Query\Builder as QueryBuilder;
use Geccomedia\Weclapp\Query\Grammars\Grammar;
use Geccomedia\Weclapp\Query\Processors\Processor;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Events\QueryExecuted;

class Connection implements ConnectionInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * The query grammar implementation.
     *
     * @var \Illuminate\Database\Query\Grammars\Grammar
     */
    protected $queryGrammar;

    /**
     * The query post processor implementation.
     *
     * @var \Illuminate\Database\Query\Processors\Processor
     */
    protected $postProcessor;

    /**
     * Create a new database connection instance.
     *
     * @param  Client $client
     * @return void
     */
    public function __construct($client)
    {
        $this->client = $client;

        // We need to initialize a query grammar and the query post processors
        // which are both very important parts of the database abstractions
        // so we initialize these to their default values while starting.
        $this->useDefaultQueryGrammar();

        $this->useDefaultPostProcessor();
    }

    /**
     * Set the query grammar to the default implementation.
     *
     * @return void
     */
    public function useDefaultQueryGrammar()
    {
        $this->queryGrammar = $this->getDefaultQueryGrammar();
    }

    /**
     * Get the default query grammar instance.
     *
     * @return Grammar
     */
    protected function getDefaultQueryGrammar()
    {
        return new Grammar;
    }

    /**
     * Set the query post processor to the default implementation.
     *
     * @return void
     */
    public function useDefaultPostProcessor()
    {
        $this->postProcessor = $this->getDefaultPostProcessor();
    }

    /**
     * Get the default post processor instance.
     *
     * @return Processor
     */
    protected function getDefaultPostProcessor()
    {
        return new Processor;
    }

    /**
     * Begin a fluent query against a database table.
     *
     * @param  \Closure|\Illuminate\Database\Query\Builder|string $table
     * @param  string|null $as
     * @return \Illuminate\Database\Query\Builder
     */
    public function table($table, $as = null)
    {
        return $this->query()->from($table, $as);
    }

    /**
     * Get a new query builder instance.
     *
     * @return QueryBuilder
     */
    public function query()
    {
        return new QueryBuilder(
            $this, $this->getQueryGrammar(), $this->getPostProcessor()
        );
    }

    /**
     * Run a select statement and return a single result.
     *
     * @param  Request $query
     * @param  array $bindings
     * @param  bool $useReadPdo
     * @return mixed
     */
    public function selectOne($query, $bindings = [], $useReadPdo = true)
    {
        $records = $this->select($query, $bindings, $useReadPdo);

        return array_shift($records);
    }

    /**
     * @param Request $query
     * @param array $bindings
     * @param bool $useReadPdo
     * @return array|bool
     */
    public function select($query, $bindings = [], $useReadPdo = true)
    {
        return $this->run($query, [], function ($query) {
            $response = $this->client->send($query);
            $items = json_decode($response->getBody(), true);

            if (is_numeric($items['result'])) {
                return [['aggregate' => $items['result']]];
            }
            if (!isset($items['result']) || count($items['result']) == 0) {
                return null;
            }
            return $items['result'];
        });
    }

    /**
     * Run an insert statement against the database.
     *
     * @param  Request $query
     * @param  array $bindings
     * @return bool
     */
    public function insert($query, $bindings = [])
    {
        return $this->run($query, [], function ($query) {
            return $this->client->send($query);
        });
    }

    /**
     * Run an update statement against the database.
     *
     * @param  Request $query
     * @param  array $bindings
     * @return int
     */
    public function update($query, $bindings = [])
    {
        return $this->run($query, [], function ($query) {
            return $this->client->send($query)->getStatusCode() == 201;
        });
    }

    /**
     * Run a delete statement against the database.
     *
     * @param  Request $query
     * @param  array $bindings
     * @return int
     */
    public function delete($query, $bindings = [])
    {
        return $this->run($query, [], function ($query) {
            return $this->client->send($query)->getStatusCode() == 204;
        });
    }

    /**
     * Get the query grammar used by the connection.
     *
     * @return \Illuminate\Database\Query\Grammars\Grammar
     */
    public function getQueryGrammar()
    {
        return $this->queryGrammar;
    }

    /**
     * Run a SQL statement and log its execution context.
     *
     * @param  Request $query
     * @param  array $bindings
     * @param  \Closure $callback
     * @return mixed
     *
     * @throws \Illuminate\Database\QueryException
     */
    protected function run($query, $bindings, Closure $callback)
    {
        return $callback($query, $bindings);
    }

    /**
     * Get the query post processor used by the connection.
     *
     * @return \Illuminate\Database\Query\Processors\Processor
     */
    public function getPostProcessor()
    {
        return $this->postProcessor;
    }

    public function getName()
    {
        return 'weclapp_api';
    }

    // @codeCoverageIgnoreStart
    public function statement($query, $bindings = [])
    {
        throw new NotSupportedException('statements are not supported by weclapp');
    }

    public function affectingStatement($query, $bindings = [])
    {
        throw new NotSupportedException('affecting statements are not supported by weclapp');
    }

    public function unprepared($query)
    {
        throw new NotSupportedException('unprepared is not supported by weclapp');
    }

    public function cursor($query, $bindings = [], $useReadPdo = true)
    {
        throw new NotSupportedException('Cursor is not supported by weclapp');
    }

    public function transaction(Closure $callback, $attempts = 1)
    {
        throw new NotSupportedException('Transactions are not supported by weclapp');
    }

    public function beginTransaction()
    {
        throw new NotSupportedException('Transactions are not supported by weclapp');
    }

    public function commit()
    {
        throw new NotSupportedException('Transactions are not supported by weclapp');
    }

    public function rollBack()
    {
        throw new NotSupportedException('Transactions are not supported by weclapp');
    }

    public function transactionLevel()
    {
        throw new NotSupportedException('Transactions are not supported by weclapp');
    }

    public function pretend(Closure $callback)
    {
        throw new NotSupportedException('pretend are not supported by weclapp');
    }

    public function raw($value)
    {
        throw new NotSupportedException('raw are not supported by weclapp');
    }

    public function prepareBindings(array $bindings)
    {
        throw new NotSupportedException('raw are not supported by weclapp');
    }
    // @codeCoverageIgnoreEnd
}
