<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $isoCode
 * @property string|null $name
 * @property bool|null $active
 * @property string|null $countryCode
 * @property string|null $languageCode
 */
class CommercialLanguage extends Model
{
    protected bool $creatable = false;

    protected bool $deletable = false;
}
