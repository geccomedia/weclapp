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
    public static function activeSalesChannels(array $params = []): ?array
    {
        return (new self)->newQuery()->action('activeSalesChannels', $params, 'GET');
    }

    /**
     * GET /salesChannelUsage
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public static function salesChannelUsage(array $params = []): ?array
    {
        return (new self)->newQuery()->action('salesChannelUsage', $params, 'GET');
    }
}
