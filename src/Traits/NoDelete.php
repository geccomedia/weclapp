<?php

namespace Geccomedia\Weclapp\Traits;

use Geccomedia\Weclapp\NotSupportedException;

/**
 * Blocks deletion: the Weclapp API has no DELETE endpoint for this resource.
 *
 * Compose with NoCreate and/or NoUpdate as needed, or use the named
 * convenience aliases IsReadOnly and IsUpdatableOnly.
 */
trait NoDelete
{
    protected function performDeleteOnModel()
    {
        throw new NotSupportedException('Deleting '.static::class.' is not supported by weclapp');
    }
}
