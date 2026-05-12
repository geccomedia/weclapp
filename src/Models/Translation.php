<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\TranslationValue;

/**
 * @property string|null $key
 * @property list<TranslationValue>|null $values
 */
class Translation extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'values' => TranslationValue::class,
    ];
}
