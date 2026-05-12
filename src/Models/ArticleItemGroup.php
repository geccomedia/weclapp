<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\ArticleItemGroupItem;

/**
 * @property list<ArticleItemGroupItem>|null $items
 * @property string|null $name
 */
class ArticleItemGroup extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'items' => ArticleItemGroupItem::class,
    ];
}
