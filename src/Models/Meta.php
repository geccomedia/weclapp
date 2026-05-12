<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $entityName
 * @property array|null $fields
 */
class Meta extends Model
{
    /**
     * GET /legacyReferenceProperties
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public static function legacyReferenceProperties(array $params = []): ?array
    {
        return (new self)->newQuery()->action('legacyReferenceProperties', $params, 'GET');
    }

    /**
     * GET /queryFilterProperties
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public static function queryFilterProperties(array $params = []): ?array
    {
        return (new self)->newQuery()->action('queryFilterProperties', $params, 'GET');
    }

    /**
     * GET /querySortProperties
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public static function querySortProperties(array $params = []): ?array
    {
        return (new self)->newQuery()->action('querySortProperties', $params, 'GET');
    }

    /**
     * GET /resources
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public static function resources(array $params = []): ?array
    {
        return (new self)->newQuery()->action('resources', $params, 'GET');
    }

    /**
     * GET /validationErrorCodes
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public static function validationErrorCodes(array $params = []): ?array
    {
        return (new self)->newQuery()->action('validationErrorCodes', $params, 'GET');
    }
}
