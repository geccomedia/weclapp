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
     * @var array
     */
    protected $operatorMappingTable = [
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
     * @var array
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
     *
     * @param  array $columns
     * @return string
     */
    public function columnize(array $columns)
    {
        return implode(',', $columns);
    }

    /**
     * Compile a select query into SQL.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return string
     */
    public function compileSelect(Builder $query)
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

        foreach($components as $component => $columns) {
          $queryColumns[] = $columns;
        }

        $queryParams = array_column($queryColumns, 1, 0);

        $query->columns = $original;

        return new Request('GET', Uri::withQueryValues(new Uri($baseUri), $queryParams));
    }

    /**
     * Compile the components necessary for a select clause.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return array
     */
    protected function compileComponents(Builder $query)
    {
        $sql = [];

        foreach ($this->selectComponents as $component) {
            // To compile the query, we'll spin through each component of the query and
            // see if that component exists. If it does we'll just call the compiler
            // function for the component which is responsible for making the SQL.
            if (isset($query->$component) && !is_null($query->$component)) {
                $method = 'compile' . ucfirst($component);

                $part = $this->$method($query, $query->$component);
                if (!is_null($part)) {
                    $sql[$component] = $part;
                }
            }
        }

        return $sql;
    }

    /**
     * Compile an aggregated select clause.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  array $aggregate
     * @return string
     */
    protected function compileAggregate(Builder $query, $aggregate)
    {
        return '/count';
    }

    /**
     * Compile the "select *" portion of the query.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  array $columns
     * @return string|null
     */
    protected function compileColumns(Builder $query, $columns)
    {
        // If the query is actually performing an aggregating select, we will let that
        // compiler handle the building of the select clauses, as it will need some
        // more syntax that is best handled by that function to keep things neat.
        if (!is_null($query->aggregate) || in_array('*', $columns)) {
            return;
        }
        return ['properties', $this->columnize($columns)];
    }

    /**
     * Compile the "from" portion of the query.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  string $table
     * @return string
     */
    protected function compileFrom(Builder $query, $table)
    {
        return $table;
    }

    /**
     * Compile the "where" portions of the query.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return array
     */
    protected function compileWheres(Builder $query)
    {
        return collect($query->wheres)->map(function ($where) use ($query) {
            if (!in_array($where['type'], ['In', 'NotIn', 'Null', 'NotNull'])) {
                $where['type'] = 'Basic';
            }
            return $this->{"where{$where['type']}"}($query, $where);
        })->all();
    }

    /**
     * Compile a basic where clause.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  array $where
     * @return string
     */
    protected function whereBasic(Builder $query, $where)
    {
        return [
            $where['column'] . '-' . $this->getOperator($where['operator']),
            $where['value']
        ];
    }

    /**
     * Compile a "where null" clause.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  array  $where
     * @return string
     */
    protected function whereNull(Builder $query, $where)
    {
        $where['value'] = '';
        $where['operator'] = 'null';
        return $this->whereBasic($query, $where);
    }

    /**
     * Compile a "where not null" clause.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  array  $where
     * @return string
     */
    protected function whereNotNull(Builder $query, $where)
    {
        $where['value'] = '';
        $where['operator'] = 'not_null';
        return $this->whereBasic($query, $where);
    }

    /**
     * Compile a "where in" clause.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  array $where
     * @return string
     */
    protected function whereIn(Builder $query, $where)
    {
        $where['value'] = json_encode($where['values']);
        $where['operator'] = 'in';
        return $this->whereBasic($query, $where);
    }

    /**
     * Compile a "where not in" clause.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  array $where
     * @return string
     */
    protected function whereNotIn(Builder $query, $where)
    {
        $where['value'] = json_encode($where['values']);
        $where['operator'] = 'not_in';
        return $this->whereBasic($query, $where);
    }

    /**
     * Compile the "order by" portions of the query.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  array $orders
     * @return string
     */
    protected function compileOrders(Builder $query, $orders)
    {
        return [
            'sort',
            implode(',', $this->compileOrdersToArray($query, $orders))
        ];
    }

    /**
     * Compile the query orders to an array.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  array $orders
     * @return array
     */
    protected function compileOrdersToArray(Builder $query, $orders)
    {
        return array_map(function ($order) {
            return ($order['direction'] == 'desc' ? '-' : '') . $order['column'];
        }, $orders);
    }

    /**
     * Compile the "limit" portions of the query.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  int $limit
     * @return string
     */
    protected function compileLimit(Builder $query, $limit)
    {
        return ['pageSize', (int)$limit];
    }

    /**
     * Compile the "offset" portions of the query.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  int $offset
     * @return string
     */
    protected function compileOffset(Builder $query, $offset)
    {
        return ['page', (int)($offset / $query->limit + 1)];
    }

    /**
     * Compile an insert statement into SQL.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  array $values
     * @return string
     */
    public function compileInsert(Builder $query, array $values)
    {
        return new Request('POST', $query->from, [], json_encode($values));
    }

    /**
     * Compile an insert and get ID statement into SQL.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  array $values
     * @param  string $sequence
     * @return string
     */
    public function compileInsertGetId(Builder $query, $values, $sequence)
    {
        return $this->compileInsert($query, $values);
    }

    /**
     * Compile a delete statement into SQL.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return string
     */
    public function compileDelete(Builder $query)
    {
        if (count($query->wheres) != 1 || $query->wheres[0]['column'] != 'id' || $query->wheres[0]['type'] != 'Basic') {
            throw new NotSupportedException('Only single delete by id is supported by weclapp.');
        }
        $key = array_shift($query->wheres);
        return new Request('DELETE', $query->from . '/' . $key['column'] . '/' . $key['value']);
    }

    /**
     * Compile an update statement into SQL.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  array $values
     * @return string
     */
    public function compileUpdate(Builder $query, $values)
    {
        if (count($query->wheres) != 1 || $query->wheres[0]['column'] != 'id' || $query->wheres[0]['type'] != 'Basic') {
            throw new NotSupportedException('Only single update by id is supported by weclapp.');
        }
        $key = array_shift($query->wheres);

        return new Request('PUT', $query->from . '/' . $key['column'] . '/' . $key['value'], [], json_encode($values));
    }

    /**
     * Get the grammar specific operators.
     *
     * @return array
     */
    public function getOperators()
    {
        return $this->operators;
    }

    // @codeCoverageIgnoreStart
    public function supportsSavepoints()
    {
        return false;
    }

    public function compileInsertUsing(Builder $query, array $columns, string $sql)
    {
        throw new NotSupportedException('Inserting using sub queries is not supported by weclapp.');
    }

    public function compileInsertOrIgnore(Builder $query, array $values)
    {
        throw new NotSupportedException('Inserting while ignoring errors is not supported by weclapp.');
    }

    protected function compileJoins(Builder $query, $joins)
    {
        throw new NotSupportedException('Joins not supported by weclapp.');
    }
    // @codeCoverageIgnoreEnd
}
