<?php

namespace Geccomedia\Weclapp\Query;

use Geccomedia\Weclapp\Connection;
use Geccomedia\Weclapp\NotSupportedException;
use Geccomedia\Weclapp\Query\Grammars\Grammar;
use Geccomedia\Weclapp\Query\Processors\Processor;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Query\Builder as BaseBuilder;
use Illuminate\Database\Query\Expression;

class Builder extends BaseBuilder
{
    public $operators = [];

    /**
     * Additional properties to request via the `additionalProperties` query parameter.
     *
     * @var array<string>|null
     */
    public ?array $additionalProperties = null;

    /**
     * Build the PSR-7 select request for the current query state.
     */
    public function buildSelectRequest(): Request
    {
        /** @var Grammar $grammar */
        $grammar = $this->grammar;

        return $grammar->buildSelectRequest($this);
    }

    /**
     * Build the PSR-7 delete request for the current query state.
     *
     * @throws NotSupportedException
     */
    public function buildDeleteRequest(): Request
    {
        /** @var Grammar $grammar */
        $grammar = $this->grammar;

        return $grammar->buildDeleteRequest($this);
    }

    /**
     * Build the PSR-7 update request for the current query state.
     *
     * @param  array<string, mixed>  $values
     *
     * @throws NotSupportedException
     */
    public function buildUpdateRequest(array $values): Request
    {
        /** @var Grammar $grammar */
        $grammar = $this->grammar;

        return $grammar->buildUpdateRequest($this, $values);
    }

    public function insert(array $values): bool
    {
        if (! is_array(reset($values))) {
            $values = [$values];
        }

        $connection = $this->connection;
        assert($connection instanceof Connection);

        /** @var Grammar $grammar */
        $grammar = $this->grammar;

        foreach ($values as $item) {
            $connection->insertRequest(
                $grammar->buildInsertRequest($this, $item),
                $this->cleanBindings($item)
            );
        }

        return true;
    }

    /**
     * Execute the query as a "select" statement.
     *
     * Overrides the Eloquent default to route through our typed grammar API
     * rather than `toSql()` → `Connection::select(string)`.
     *
     * @return array<int, mixed>
     */
    public function runSelect(): array
    {
        $connection = $this->connection;
        assert($connection instanceof Connection);

        return $connection->selectRequest($this->buildSelectRequest()) ?? [];
    }

    /**
     * Delete records from the database.
     *
     * @param  mixed  $id
     * @return int
     */
    public function delete($id = null)
    {
        if (! is_null($id)) {
            $this->where($this->from.'.id', '=', $id);
        }

        $connection = $this->connection;
        assert($connection instanceof Connection);

        return $connection->deleteRequest($this->buildDeleteRequest()) ? 1 : 0;
    }

    /**
     * Update records in the database.
     *
     * @param  array<string, mixed>  $values
     */
    public function update(array $values): int
    {
        $connection = $this->connection;
        assert($connection instanceof Connection);

        return (int) $connection->updateRequest(
            $this->buildUpdateRequest($values),
            $this->cleanBindings(
                $this->grammar->prepareBindingsForUpdate($this->bindings, $values)
            )
        );
    }

    /**
     * Insert a new record and get the value of the primary key.
     *
     * @param  string|null  $sequence
     */
    public function insertGetId(array $values, $sequence = null): mixed
    {
        /** @var Grammar $grammar */
        $grammar = $this->grammar;

        $sql = $grammar->buildInsertRequest($this, $values);

        $processor = $this->processor;
        assert($processor instanceof Processor);

        $id = $processor->processInsertGetId($this, $sql, $values, $sequence);

        return is_numeric($id) ? (int) $id : $id;
    }

    /**
     * Remove all of the expressions from a list of bindings.
     *
     * @param  array<mixed>  $bindings
     * @return array<mixed>
     */
    public function cleanBindings(array $bindings): array
    {
        return array_filter($bindings, function ($binding) {
            return ! $binding instanceof Expression;
        });
    }

    /**
     * @throws NotSupportedException
     */
    public function selectSub($query, $as)
    {
        throw new NotSupportedException('Sub-Selects are not supported by weclapp');
    }

    /**
     * @throws NotSupportedException
     */
    public function whereRaw($sql, $bindings = [], $boolean = 'and')
    {
        throw new NotSupportedException('Raw wheres are not supported by weclapp');
    }

    /**
     * @throws NotSupportedException
     */
    public function truncate()
    {
        throw new NotSupportedException('truncate wheres are not supported by weclapp');
    }

    /**
     * @throws NotSupportedException
     */
    public function raw($value)
    {
        throw new NotSupportedException('raw wheres are not supported by weclapp');
    }

    /**
     * @throws NotSupportedException
     */
    protected function whereSub($column, $operator, $callback, $boolean)
    {
        throw new NotSupportedException('whereSub wheres are not supported by weclapp');
    }

    /**
     * @throws NotSupportedException
     */
    public function union($query, $all = false)
    {
        throw new NotSupportedException('union wheres are not supported by weclapp');
    }
}
