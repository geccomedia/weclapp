<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $type
 */
class NumberRange extends Model
{
    protected bool $creatable = false;

    protected bool $deletable = false;

    /**
     * GET /missingNumberRanges
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public static function missingNumberRanges(array $params = []): ?array
    {
        return (new self)->newQuery()->action('missingNumberRanges', $params, 'GET');
    }
}
