<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\Traits\IsReadOnly;

/**
 * @property string|null $description
 * @property string|null $entityId
 * @property string|null $entityName
 * @property string|null $priority
 * @property bool|null $read
 * @property string|null $title
 */
class Notification extends Model
{
    use IsReadOnly;

    /**
     * POST /markRead
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function markRead(array $params = []): ?array
    {
        return $this->callAction('markRead', $params, 'POST');
    }
}
