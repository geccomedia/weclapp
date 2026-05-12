<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\Traits\IsReadOnly;

/**
 * @property string|null $isoCode
 * @property string|null $name
 * @property bool|null $active
 * @property string|null $countryCode
 * @property string|null $languageCode
 */
class CommercialLanguage extends Model
{
    use IsReadOnly;
}
