<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $name
 * @property string|null $description
 * @property bool|null $active
 * @property string|null $key
 */
class SalesChannel extends Model
{
    /**
     * GET /activeSalesChannels
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function activeSalesChannels(array $params = []): ?array
    {
        return $this->callAction('activeSalesChannels', $params, 'GET');
    }

    /**
     * GET /salesChannelUsage
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function salesChannelUsage(array $params = []): ?array
    {
        return $this->callAction('salesChannelUsage', $params, 'GET');
    }
}
