<?php

namespace Geccomedia\Weclapp\Query\Grammars;

use Geccomedia\Weclapp\NotSupportedException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\Grammar as BaseGrammar;

class Grammar extends BaseGrammar
{
    /**
     * Mapping table from normal eloquent operators to weclapp
     */
    protected array $operatorMappingTable = [
        '=' => 'eq',
        '!=' => 'ne',
        '>' => 'gt',
        '>=' => 'ge',
        '<' => 'lt',
        '<=' => 'le',
        'in' => 'in',
        'not_in' => 'notin',
        'null' => 'null',
        'not_null' => 'notnull',
        'like' => 'like',
        'not_like' => 'notlike',
        'ilike' => 'ilike',
        'not_ilike' => 'notilike',
    ];

    public function __construct()
    {
        $this->operators = array_keys($this->operatorMappingTable);
    }

    private function getOperator($operator)
    {
        return $this->operatorMappingTable[strtolower($operator)];
    }

    /**
     * The components that make up a select clause.
     *
     * @var array<string>
     */
    protected $selectComponents = [
        'from',
        'aggregate',
        'columns',
        'wheres',
        'orders',
        'offset',
        'limit',
    ];

    /**
     * Convert an array of column names into a delimited string.
     */
    public function columnize(array $columns): string
    {
        return implode(',', $columns);
    }

    /**
     * Compile a select query into SQL.
     */
    /** @phpstan-ignore method.childReturnType */
    public function compileSelect(Builder $query): Request
    {
        // If the query does not have any columns set, we'll set the columns to the
        // * character to just get all of the columns from the database. Then we
        // can build the query and concatenate all the pieces together as one.
        $original = $query->columns;

        if (is_null($query->columns)) {
            $query->columns = ['*'];
        }

        // To compile the query, we'll spin through each component of the query and
        // see if that component exists. If it does we'll just call the compiler
        // function for the component which is responsible for making the SQL.
        $components = $this->compileComponents($query);
        $baseUri = $components['from'];
        unset($components['from']);
        if (isset($components['aggregate'])) {
            $baseUri .= $components['aggregate'];
            unset($components['aggregate']);
        }

        $queryColumns = $components['wheres'];
        unset($components['wheres']);

        foreach ($components as $columns) {
            $queryColumns[] = $columns;
        }

        $queryParams = array_column($queryColumns, 1, 0);

        $query->columns = $original;

        return new Request('GET', Uri::withQueryValues(new Uri($baseUri), $queryParams));
    }

    /**
     * Compile the components necessary for a select clause.
     */
    protected function compileComponents(Builder $query): array
    {
        $sql = [];

        foreach ($this->selectComponents as $component) {
            // To compile the query, we'll spin through each component of the query and
            // see if that component exists. If it does we'll just call the compiler
            // function for the component which is responsible for making the SQL.
            if (isset($query->$component)) {
                $method = 'compile'.ucfirst($component);

                $part = $this->$method($query, $query->$component);
                if (! is_null($part)) {
                    $sql[$component] = $part;
                }
            }
        }

        return $sql;
    }

    /**
     * Compile an aggregated select clause.
     *
     * @param  array  $aggregate
     */
    protected function compileAggregate(Builder $query, $aggregate): string
    {
        return '/count';
    }

    /**
     * Compile the "select *" portion of the query.
     *
     * @param  array  $columns
     * @return array|void
     */
    // @phpstan-ignore-next-line method.childReturnType
    protected function compileColumns(Builder $query, $columns)
    {
        // If the query is actually performing an aggregating select, we will let that
        // compiler handle the building of the select clauses, as it will need some
        // more syntax that is best handled by that function to keep things neat.
        if (! is_null($query->aggregate) || in_array('*', $columns)) {
            return;
        }

        return ['properties', $this->columnize($columns)];
    }

    /**
     * Compile the "from" portion of the query.
     *
     * @param  string  $table
     */
    protected function compileFrom(Builder $query, $table): string
    {
        return $table;
    }

    /**
     * Compile the "where" portions of the query.
     */
    /** @phpstan-ignore method.childReturnType */
    public function compileWheres(Builder $query): array
    {
        return collect($query->wheres)->map(function ($where) use ($query) {
            if (! in_array($where['type'], ['In', 'NotIn', 'InRaw', 'NotInRaw', 'Null', 'NotNull', 'Entity'])) {
                $where['type'] = 'Basic';
            }

            // InRaw / NotInRaw are produced by Eloquent's whereIntegerInRaw() for
            // eager-loading on integer key types. They have the same shape as
            // In / NotIn (a 'values' array), so we map them down to our handlers.
            if ($where['type'] === 'InRaw') {
                $where['type'] = 'In';
            } elseif ($where['type'] === 'NotInRaw') {
                $where['type'] = 'NotIn';
            }

            return $this->{"where{$where['type']}"}($query, $where);
        })->all();
    }

    /**
     * Compile a basic where clause.
     *
     * @param  array  $where
     */
    /** @phpstan-ignore method.childReturnType */
    protected function whereBasic(Builder $query, $where): array
    {
        return [
            $where['column'].'-'.$this->getOperator($where['operator']),
            $where['value'],
        ];
    }

    /**
     * Compile a "where entity" clause.
     * See https://github.com/geccomedia/weclapp/issues/22
     */
    protected function whereEntity(Builder $query, array $where): array
    {
        return [
            $where['column'],
            $where['value'],
        ];
    }

    /**
     * Compile a "where null" clause.
     *
     * @param  array  $where
     */
    /** @phpstan-ignore method.childReturnType */
    protected function whereNull(Builder $query, $where): array
    {
        $where['value'] = '';
        $where['operator'] = 'null';

        return $this->whereBasic($query, $where);
    }

    /**
     * Compile a "where not null" clause.
     *
     * @param  array  $where
     */
    /** @phpstan-ignore method.childReturnType */
    protected function whereNotNull(Builder $query, $where): array
    {
        $where['value'] = '';
        $where['operator'] = 'not_null';

        return $this->whereBasic($query, $where);
    }

    /**
     * Compile a "where in" clause.
     *
     * @param  array  $where
     */
    /** @phpstan-ignore method.childReturnType */
    protected function whereIn(Builder $query, $where): array
    {
        $where['value'] = json_encode($where['values']);
        $where['operator'] = 'in';

        return $this->whereBasic($query, $where);
    }

    /**
     * Compile a "where not in" clause.
     *
     * @param  array  $where
     */
    /** @phpstan-ignore method.childReturnType */
    protected function whereNotIn(Builder $query, $where): array
    {
        $where['value'] = json_encode($where['values']);
        $where['operator'] = 'not_in';

        return $this->whereBasic($query, $where);
    }

    /**
     * Compile the "order by" portions of the query.
     *
     * @param  array  $orders
     */
    /** @phpstan-ignore method.childReturnType */
    protected function compileOrders(Builder $query, $orders): array
    {
        return [
            'sort',
            implode(',', $this->compileOrdersToArray($query, $orders)),
        ];
    }

    /**
     * Compile the query orders to an array.
     *
     * @param  array  $orders
     */
    protected function compileOrdersToArray(Builder $query, $orders): array
    {
        return array_map(function ($order) {
            return ($order['direction'] == 'desc' ? '-' : '').$order['column'];
        }, $orders);
    }

    /**
     * Compile the "limit" portions of the query.
     *
     * @param  int  $limit
     */
    /** @phpstan-ignore method.childReturnType */
    protected function compileLimit(Builder $query, $limit): array
    {
        return ['pageSize', (int) $limit];
    }

    /**
     * Compile the "offset" portions of the query.
     *
     * @param  int  $offset
     */
    /** @phpstan-ignore method.childReturnType */
    protected function compileOffset(Builder $query, $offset): array
    {
        return ['page', (int) ($offset / $query->limit + 1)];
    }

    /**
     * Compile an insert statement into SQL.
     */
    /** @phpstan-ignore method.childReturnType */
    public function compileInsert(Builder $query, array $values): Request
    {
        return new Request('POST', $query->from, [], json_encode($values));
    }

    /**
     * Compile an insert and get ID statement into SQL.
     *
     * @param  array  $values
     * @param  string  $sequence
     */
    /** @phpstan-ignore method.childReturnType */
    public function compileInsertGetId(Builder $query, $values, $sequence): Request
    {
        return $this->compileInsert($query, $values);
    }

    /**
     * Compile a delete statement into SQL.
     *
     * @throws NotSupportedException
     */
    /** @phpstan-ignore method.childReturnType */
    public function compileDelete(Builder $query): Request
    {
        if (count($query->wheres) != 1 || $query->wheres[0]['column'] != 'id' || $query->wheres[0]['type'] != 'Basic') {
            throw new NotSupportedException('Only single delete by id is supported by weclapp.');
        }
        $key = array_shift($query->wheres);

        return new Request('DELETE', $query->from.'/'.$key['column'].'/'.$key['value']);
    }

    /**
     * Compile an update statement into SQL.
     *
     * @throws NotSupportedException
     */
    /** @phpstan-ignore method.childReturnType */
    public function compileUpdate(Builder $query, array $values): Request
    {
        if (count($query->wheres) != 1 || $query->wheres[0]['column'] != 'id' || $query->wheres[0]['type'] != 'Basic') {
            throw new NotSupportedException('Only single update by id is supported by weclapp.');
        }
        $key = array_shift($query->wheres);

        return new Request('PUT', $query->from.'/'.$key['column'].'/'.$key['value'], [], json_encode($values));
    }

    /**
     * Prepare the bindings for an update statement.
     */
    public function prepareBindingsForUpdate(array $bindings, array $values): array
    {
        return $values;
    }

    /**
     * Get the grammar specific operators.
     */
    public function getOperators(): array
    {
        return $this->operators;
    }

    // @codeCoverageIgnoreStart
    public function supportsSavepoints(): bool
    {
        return false;
    }

    /**
     * @throws NotSupportedException
     */
    public function compileInsertUsing(Builder $query, array $columns, string $sql)
    {
        throw new NotSupportedException('Inserting using sub queries is not supported by weclapp.');
    }

    /**
     * @throws NotSupportedException
     */
    public function compileInsertOrIgnore(Builder $query, array $values)
    {
        throw new NotSupportedException('Inserting while ignoring errors is not supported by weclapp.');
    }

    /**
     * @throws NotSupportedException
     */
    protected function compileJoins(Builder $query, $joins)
    {
        throw new NotSupportedException('Joins not supported by weclapp.');
    }
    // @codeCoverageIgnoreEnd
}
