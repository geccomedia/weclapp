<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\Traits\IsReadOnly;

/**
 * @property string|null $type
 */
class NumberRange extends Model
{
    use IsReadOnly;

    /**
     * GET /missingNumberRanges
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function missingNumberRanges(array $params = []): ?array
    {
        return $this->callAction('missingNumberRanges', $params, 'GET');
    }
}
