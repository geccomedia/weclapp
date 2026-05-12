<?php

namespace Geccomedia\Weclapp\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Restricts queries to party records that are active leads:
 * - `leadStatus` is set (the party has entered the sales funnel), AND
 * - `leadStatus` is not CONVERTED (they have not yet become a customer).
 *
 * Parties with leadStatus = CONVERTED are customers; they are excluded here
 * and will appear under the Customer model instead.
 */
class LeadScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder
            ->whereNotNull('leadStatus')
            ->where('leadStatus', '!=', 'CONVERTED');
    }
}
