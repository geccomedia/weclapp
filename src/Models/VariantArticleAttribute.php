<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\VariantArticleAttributeOption;

/**
 * @property string|null $name
 * @property array|null $values
 * @property list<VariantArticleAttributeOption>|null $attributeOptions
 */
class VariantArticleAttribute extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'attributeOptions' => VariantArticleAttributeOption::class,
    ];
}
