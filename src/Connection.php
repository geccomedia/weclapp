<?php

namespace Geccomedia\Weclapp;

use Closure;
use Geccomedia\Weclapp\Query\Builder as QueryBuilder;
use Geccomedia\Weclapp\Query\Grammars\Grammar;
use Geccomedia\Weclapp\Query\Processors\Processor;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Connection as BaseConnection;
use Illuminate\Database\Query\Builder;
use Psr\Http\Message\ResponseInterface;

class Connection extends BaseConnection
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Create a new database connection instance.
     *
     * @param  Client  $client
     * @return void
     */
    public function __construct($client)
    {
        // Pass a lazy PDO closure — it is never invoked since we override all
        // PDO-dependent methods to use our HTTP client instead.
        parent::__construct(static fn (): \PDO => throw new \LogicException('PDO is not used by this connection'), 'weclapp_api');

        $this->client = $client;

        if (app()->bound('events')) {
            $this->setEventDispatcher(app('events'));
        }
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
     * @param  Closure|Builder|string  $table
     * @param  string|null  $as
     * @return Builder
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
     * Execute a GET request and return the decoded result rows.
     *
     * This is the primary read path used by {@see QueryBuilder::runSelect()}.
     *
     * @return array<int, mixed>|null
     */
    public function selectRequest(Request $request): ?array
    {
        return $this->runRequest($request, [], function (Request $req) {
            $response = $this->client->send($req);
            $items = json_decode($response->getBody(), true);

            if (! isset($items['result'])) {
                return null;
            }
            if (is_array($items['result']) && count($items['result']) == 0) {
                return null;
            }
            if (is_numeric($items['result'])) {
                return [['aggregate' => $items['result']]];
            }

            return $items['result'];
        });
    }

    /**
     * Execute a POST request and log the result.
     *
     * Used by {@see QueryBuilder::insert()}.
     */
    public function insertRequest(Request $request, array $bindings = []): bool
    {
        $this->runRequest($request, $bindings, fn (Request $req) => $this->client->send($req));

        return true;
    }

    /**
     * Execute an insert and return the raw HTTP response.
     *
     * Used by {@see Processor::processInsertGetId()}.
     *
     * @param  array<mixed>  $bindings
     */
    public function insertAndGetResponse(Request $request, array $bindings = []): ResponseInterface
    {
        return $this->runRequest($request, $bindings, fn (Request $req) => $this->client->send($req));
    }

    /**
     * Execute a PUT request and log the result.
     *
     * Used by {@see QueryBuilder::update()}.
     */
    public function updateRequest(Request $request, array $bindings = []): bool
    {
        return (bool) $this->runRequest($request, $bindings, fn (Request $req) => $this->client->send($req)->getStatusCode() == 201);
    }

    /**
     * Execute a DELETE request and log the result.
     *
     * Used by {@see QueryBuilder::delete()}.
     */
    public function deleteRequest(Request $request): bool
    {
        return (bool) $this->runRequest($request, [], fn (Request $req) => $this->client->send($req)->getStatusCode() == 204);
    }

    /**
     * Execute a custom action endpoint and return the decoded response body.
     *
     * @return array<mixed>|null
     */
    public function action(Request $query): ?array
    {
        return $this->runRequest($query, [], function (Request $request) {
            $response = $this->client->send($request);
            $body = json_decode((string) $response->getBody(), true);

            return $body ?? null;
        });
    }

    /**
     * Execute an HTTP request, log the query, and return the result.
     *
     * @param  array<mixed>  $bindings
     * @return mixed
     */
    protected function runRequest(Request $query, array $bindings, Closure $callback)
    {
        $start = microtime(true);

        $result = $callback($query);

        $this->logQuery(
            $query->getMethod().':'.$query->getUri(), $bindings, $this->getElapsedTime($start)
        );

        return $result;
    }

    /**
     * Get the name of the connected database.
     *
     * @return string
     */
    public function getDatabaseName()
    {
        return 'weclapp_api';
    }

    public function select($query, $bindings = [], $useReadPdo = true, array $fetchUsing = [])
    {
        throw new NotSupportedException('Use selectRequest(Request) instead.');
    }

    public function selectOne($query, $bindings = [], $useReadPdo = true)
    {
        throw new NotSupportedException('Use selectRequest(Request) instead.');
    }

    public function insert($query, $bindings = [])
    {
        throw new NotSupportedException('Use insertRequest(Request) instead.');
    }

    public function update($query, $bindings = [])
    {
        throw new NotSupportedException('Use updateRequest(Request) instead.');
    }

    public function delete($query, $bindings = [])
    {
        throw new NotSupportedException('Use deleteRequest(Request) instead.');
    }

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

    public function cursor($query, $bindings = [], $useReadPdo = true, array $fetchUsing = [])
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

    public function rollBack($toLevel = null)
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
        return $bindings;
    }

    public function scalar($query, $bindings = [], $useReadPdo = true)
    {
        throw new NotSupportedException('scalar not supported by weclapp');
    }
}
