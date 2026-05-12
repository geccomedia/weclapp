<?php

namespace Geccomedia\Weclapp\Traits;

/**
 * Marks a model as fully read-only: no POST, no PUT, no DELETE.
 *
 * Convenience alias for `use NoCreate, NoUpdate, NoDelete`.
 */
trait IsReadOnly
{
    use NoCreate, NoDelete, NoUpdate;
}
