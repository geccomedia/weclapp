<?php

namespace Geccomedia\Weclapp\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Restricts queries to party records that are flagged as suppliers
 * (i.e. `supplier = true` on the weclapp party object).
 */
class SupplierScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('supplier', 'true');
    }
}
