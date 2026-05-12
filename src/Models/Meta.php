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
    public function legacyReferenceProperties(array $params = []): ?array
    {
        return $this->callAction('legacyReferenceProperties', $params, 'GET');
    }

    /**
     * GET /queryFilterProperties
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function queryFilterProperties(array $params = []): ?array
    {
        return $this->callAction('queryFilterProperties', $params, 'GET');
    }

    /**
     * GET /querySortProperties
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function querySortProperties(array $params = []): ?array
    {
        return $this->callAction('querySortProperties', $params, 'GET');
    }

    /**
     * GET /resources
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function resources(array $params = []): ?array
    {
        return $this->callAction('resources', $params, 'GET');
    }

    /**
     * GET /validationErrorCodes
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function validationErrorCodes(array $params = []): ?array
    {
        return $this->callAction('validationErrorCodes', $params, 'GET');
    }
}
