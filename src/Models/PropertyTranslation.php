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
}
