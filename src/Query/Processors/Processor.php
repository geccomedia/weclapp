<?php

namespace Geccomedia\Weclapp\Query\Processors;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Processors\Processor as BaseProcessor;

class Processor extends BaseProcessor
{
    /**
     * Process an  "insert get ID" query.
     *
     * @param  string  $sql
     * @param  array  $values
     * @param  string|null  $sequence
     */
    public function processInsertGetId(Builder $query, $sql, $values, $sequence = null)
    {
        $results = $query->getConnection()->insert($sql, $values);

        /** @phpstan-ignore method.nonObject */
        return json_decode($results->getBody(), true);
    }
}
