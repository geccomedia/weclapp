<?php

namespace Geccomedia\Weclapp\Query\Processors;

use Geccomedia\Weclapp\Connection;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Processors\Processor as BaseProcessor;

class Processor extends BaseProcessor
{
    /**
     * Process an  "insert get ID" query.
     *
     * @param  mixed  $sql
     * @param  array  $values
     * @param  string|null  $sequence
     * @return mixed
     */
    public function processInsertGetId(Builder $query, $sql, $values, $sequence = null)
    {
        $connection = $query->getConnection();

        if ($connection instanceof Connection && $sql instanceof Request) {
            return json_decode($connection->insertAndGetResponse($sql, $values)->getBody(), true);
        }

        return null;
    }
}
