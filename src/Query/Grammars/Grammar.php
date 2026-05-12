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

    private function getOperator(string $operator): string
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
        'additionalProperties',
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
     * Build a PSR-7 GET request for a select query.
     */
    public function buildSelectRequest(Builder $query): Request
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
        $components = $this->buildComponents($query);
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
     * Build the components necessary for a select clause.
     *
     * @return array<string, mixed>
     */
    protected function buildComponents(Builder $query): array
    {
        $sql = [];

        foreach ($this->selectComponents as $component) {
            // To compile the query, we'll spin through each component of the query and
            // see if that component exists. If it does we'll just call the compiler
            // function for the component which is responsible for making the SQL.
            if (isset($query->$component)) {
                $method = 'build'.ucfirst($component);

                $part = $this->$method($query, $query->$component);
                if (! is_null($part)) {
                    $sql[$component] = $part;
                }
            }
        }

        return $sql;
    }

    /**
     * Build an aggregated select clause.
     *
     * @param  array  $aggregate
     */
    protected function buildAggregate(Builder $query, $aggregate): string
    {
        return '/count';
    }

    /**
     * Build the "select *" portion of the query.
     *
     * @param  array  $columns
     * @return array<string>|null
     */
    protected function buildColumns(Builder $query, $columns): ?array
    {
        // If the query is actually performing an aggregating select, we will let that
        // compiler handle the building of the select clauses, as it will need some
        // more syntax that is best handled by that function to keep things neat.
        if (! is_null($query->aggregate) || in_array('*', $columns)) {
            return null;
        }

        return ['properties', $this->columnize($columns)];
    }

    /**
     * Build the "additionalProperties" portion of the query.
     *
     * @param  array<string>  $additionalProperties
     * @return array<string>|null
     */
    protected function buildAdditionalProperties(Builder $query, $additionalProperties): ?array
    {
        if (empty($additionalProperties)) {
            return null;
        }

        return ['additionalProperties', $this->columnize($additionalProperties)];
    }

    /**
     * Build the "from" portion of the query.
     *
     * @param  string  $table
     */
    protected function buildFrom(Builder $query, $table): string
    {
        return $table;
    }

    /**
     * Build the "where" portions of the query.
     *
     * @return array<int, mixed>
     */
    public function buildWheres(Builder $query): array
    {
        return collect($query->wheres)->map(function ($where) use ($query) {
            // Normalise PHP booleans to their string equivalents before any
            // handler serialises them into the query string. This covers every
            // where type (Basic, In, NotIn, Entity, …) in one place.
            if (isset($where['value']) && is_bool($where['value'])) {
                $where['value'] = var_export($where['value'], true);
            }
            if (isset($where['values'])) {
                $where['values'] = array_map(
                    fn ($v) => is_bool($v) ? var_export($v, true) : $v,
                    $where['values']
                );
            }

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

            return $this->{"build{$where['type']}Where"}($query, $where);
        })->all();
    }

    /**
     * Build a basic where clause.
     *
     * @param  array<string, mixed>  $where
     * @return array<int, mixed>
     */
    protected function buildBasicWhere(Builder $query, array $where): array
    {
        return [
            $where['column'].'-'.$this->getOperator($where['operator']),
            $where['value'],
        ];
    }

    /**
     * Build a "where entity" clause.
     * See https://github.com/geccomedia/weclapp/issues/22
     *
     * @param  array<string, mixed>  $where
     * @return array<int, mixed>
     */
    protected function buildEntityWhere(Builder $query, array $where): array
    {
        return [
            $where['column'],
            $where['value'],
        ];
    }

    /**
     * Build a "where null" clause.
     *
     * @param  array<string, mixed>  $where
     * @return array<int, mixed>
     */
    protected function buildNullWhere(Builder $query, array $where): array
    {
        $where['value'] = '';
        $where['operator'] = 'null';

        return $this->buildBasicWhere($query, $where);
    }

    /**
     * Build a "where not null" clause.
     *
     * @param  array<string, mixed>  $where
     * @return array<int, mixed>
     */
    protected function buildNotNullWhere(Builder $query, array $where): array
    {
        $where['value'] = '';
        $where['operator'] = 'not_null';

        return $this->buildBasicWhere($query, $where);
    }

    /**
     * Build a "where in" clause.
     *
     * @param  array<string, mixed>  $where
     * @return array<int, mixed>
     */
    protected function buildInWhere(Builder $query, array $where): array
    {
        $where['value'] = json_encode($where['values']);
        $where['operator'] = 'in';

        return $this->buildBasicWhere($query, $where);
    }

    /**
     * Build a "where not in" clause.
     *
     * @param  array<string, mixed>  $where
     * @return array<int, mixed>
     */
    protected function buildNotInWhere(Builder $query, array $where): array
    {
        $where['value'] = json_encode($where['values']);
        $where['operator'] = 'not_in';

        return $this->buildBasicWhere($query, $where);
    }

    /**
     * Build the "order by" portions of the query.
     *
     * @param  array<int, mixed>  $orders
     * @return array<int, string>
     */
    protected function buildOrders(Builder $query, array $orders): array
    {
        return [
            'sort',
            implode(',', $this->buildOrdersToArray($query, $orders)),
        ];
    }

    /**
     * Build the query orders to an array.
     *
     * @param  array<int, mixed>  $orders
     * @return array<int, string>
     */
    protected function buildOrdersToArray(Builder $query, array $orders): array
    {
        return array_map(function ($order) {
            return ($order['direction'] == 'desc' ? '-' : '').$order['column'];
        }, $orders);
    }

    /**
     * Build the "limit" portions of the query.
     *
     * @return array<int, int|string>
     */
    protected function buildLimit(Builder $query, int $limit): array
    {
        return ['pageSize', (int) $limit];
    }

    /**
     * Build the "offset" portions of the query.
     *
     * @return array<int, int|string>
     */
    protected function buildOffset(Builder $query, int $offset): array
    {
        return ['page', (int) ($offset / $query->limit + 1)];
    }

    /**
     * Build a PSR-7 POST request for an insert statement.
     */
    public function buildInsertRequest(Builder $query, array $values): Request
    {
        return new Request('POST', $query->from, [], json_encode($values));
    }

    /**
     * Build a PSR-7 DELETE request for a delete statement.
     *
     * @throws NotSupportedException
     */
    public function buildDeleteRequest(Builder $query): Request
    {
        if (count($query->wheres) != 1 || $query->wheres[0]['column'] != 'id' || $query->wheres[0]['type'] != 'Basic') {
            throw new NotSupportedException('Only single delete by id is supported by weclapp.');
        }
        $key = array_shift($query->wheres);

        return new Request('DELETE', $query->from.'/'.$key['column'].'/'.$key['value']);
    }

    /**
     * Build a PSR-7 PUT request for an update statement.
     *
     * @throws NotSupportedException
     */
    public function buildUpdateRequest(Builder $query, array $values): Request
    {
        if (count($query->wheres) != 1 || $query->wheres[0]['column'] != 'id' || $query->wheres[0]['type'] != 'Basic') {
            throw new NotSupportedException('Only single update by id is supported by weclapp.');
        }
        $key = array_shift($query->wheres);

        return new Request('PUT', $query->from.'/'.$key['column'].'/'.$key['value'], [], json_encode($values));
    }

    /**
     * Compile a custom action endpoint request.
     *
     * Instance action:   POST /salesOrder/id/{id}/createShipment
     *                    GET  /document/id/{id}/download
     * Collection action: POST /salesOrder/defaultValuesForCreate
     *                    GET  /system/permissions
     *
     * @param  string  $action  The action name, e.g. "createShipment"
     * @param  array<mixed>  $params  For POST: JSON body. For GET: query parameters appended to the URI.
     * @param  string|null  $id  Record ID for instance actions; null for collection actions
     * @param  string  $method  HTTP method — 'POST' (default) or 'GET'
     */
    public function compileAction(Builder $query, string $action, array $params = [], ?string $id = null, string $method = 'POST'): Request
    {
        $uri = $id !== null
            ? $query->from.'/id/'.$id.'/'.$action
            : $query->from.'/'.$action;

        if (strtoupper($method) === 'GET') {
            $uri = empty($params)
                ? $uri
                : (string) Uri::withQueryValues(new Uri($uri), $params);

            return new Request('GET', $uri);
        }

        $body = empty($params) ? null : json_encode($params);

        return new Request('POST', $uri, [], $body);
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

    public function supportsSavepoints(): bool
    {
        return false;
    }

    /**
     * @throws NotSupportedException
     */
    public function compileInsertUsing(Builder $query, array $columns, string $sql): string
    {
        throw new NotSupportedException('Inserting using sub queries is not supported by weclapp.');
    }

    /**
     * @throws NotSupportedException
     */
    public function compileInsertOrIgnore(Builder $query, array $values): string
    {
        throw new NotSupportedException('Inserting while ignoring errors is not supported by weclapp.');
    }

    /**
     * @throws NotSupportedException
     */
    protected function compileJoins(Builder $query, $joins): string
    {
        throw new NotSupportedException('Joins not supported by weclapp.');
    }
}
