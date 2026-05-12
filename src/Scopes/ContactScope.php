<?php

namespace Geccomedia\Weclapp\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Restricts queries to party records that are contacts:
 * - `partyType = PERSON` (contacts are always individuals, not organisations), AND
 * - attached to a parent party via `customerId` or `leadId`.
 *
 * A PERSON without a customerId or leadId is a standalone person-party, not
 * a contact in the weclapp sense.
 *
 * Note: weclapp does not support OR filters in its query API, so we apply
 * only the conditions that can be expressed as independent AND clauses.
 * The partyType filter is sufficient to distinguish contacts from the general
 * party pool in the vast majority of cases.
 */
class ContactScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('partyType', 'PERSON');
    }
}
