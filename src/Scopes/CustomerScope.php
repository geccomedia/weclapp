<?php

namespace Geccomedia\Weclapp\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Restricts queries to party records that are flagged as customers
 * (i.e. `customer = true` on the weclapp party object).
 */
class CustomerScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('customer', 'true');
    }
}
