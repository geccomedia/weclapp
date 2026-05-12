<?php

namespace Geccomedia\Weclapp\Traits;

use Geccomedia\Weclapp\NotSupportedException;
use Illuminate\Database\Eloquent\Builder;

/**
 * Blocks updates: the Weclapp API has no PUT endpoint for this resource.
 *
 * Compose with NoCreate and/or NoDelete as needed, or use the named
 * convenience aliases IsReadOnly and IsUpdatableOnly.
 */
trait NoUpdate
{
    protected function performUpdate(Builder $query)
    {
        throw new NotSupportedException('Updating '.static::class.' is not supported by weclapp');
    }
}
