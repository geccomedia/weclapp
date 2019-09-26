<?php

namespace Geccomedia\Weclapp\Query\Processors;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Processors\Processor as BaseProcessor;

class Processor extends BaseProcessor
{
    /**
     * Process an  "insert get ID" query.
     *
     * @param  Builder  $query
     * @param  string  $sql
     * @param  array   $values
     * @param  string|null  $sequence
     * @return array
     */
    public function processInsertGetId(Builder $query, $sql, $values, $sequence = null)
    {
        $results = $query->getConnection()->insert($sql, $values);

        return json_decode($results->getBody(), true);
    }
}
