<?php

namespace Geccomedia\Weclapp\Query;

use Geccomedia\Weclapp\NotSupportedException;
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

    public function insert(array $values): bool
    {
        if (! is_array(reset($values))) {
            $values = [$values];
        }

        foreach ($values as $item) {
            $this->connection->insert(
                $this->grammar->compileInsert($this, $item),
                $this->cleanBindings($item)
            );
        }

        return true;
    }

    /**
     * Remove all of the expressions from a list of bindings.
     */
    public function cleanBindings(array $bindings): array
    {
        return array_filter($bindings, function ($binding) {
            return ! $binding instanceof Expression;
        });
    }

    // @codeCoverageIgnoreStart

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
    // @codeCoverageIgnoreEnd
}
