<?php

namespace Geccomedia\Weclapp\Traits;

/**
 * Marks a model as updatable but not creatable or deletable: no POST, no DELETE.
 *
 * Convenience alias for `use NoCreate, NoDelete`.
 */
trait IsUpdatableOnly
{
    use NoCreate, NoDelete;
}
