<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\PropertyTranslationValue;

/**
 * @property string|null $propertyName
 * @property list<PropertyTranslationValue>|null $values
 */
class PropertyTranslation extends Model
{
    protected $casts = [
        'values' => PropertyTranslationValue::class,
    ];

    /**
     * GET /readPropertyTranslations
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function readPropertyTranslations(array $params = []): ?array
    {
        return $this->callAction('readPropertyTranslations', $params, 'GET');
    }

    /**
     * POST /updatePropertyTranslations
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function updatePropertyTranslations(array $params = []): ?array
    {
        return $this->callAction('updatePropertyTranslations', $params, 'POST');
    }
}
