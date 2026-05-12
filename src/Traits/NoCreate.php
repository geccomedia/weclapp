<?php

namespace Geccomedia\Weclapp\Traits;

use Geccomedia\Weclapp\NotSupportedException;
use Illuminate\Database\Eloquent\Builder;

/**
 * Blocks creation: the Weclapp API has no POST endpoint for this resource.
 *
 * Compose with NoUpdate and/or NoDelete as needed, or use the named
 * convenience aliases IsReadOnly and IsUpdatableOnly.
 */
trait NoCreate
{
    protected function performInsert(Builder $query)
    {
        throw new NotSupportedException('Creating '.static::class.' is not supported by weclapp');
    }
}
