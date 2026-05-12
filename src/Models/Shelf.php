<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\NestedStoragePlace;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $active
 * @property string|null $shortIdentifier
 * @property string|null $storageLocationId
 * @property list<NestedStoragePlace>|null $storagePlaces
 */
class Shelf extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'storagePlaces' => NestedStoragePlace::class,
    ];

    /**
     * @return BelongsTo
     */
    public function storageLocation()
    {
        return $this->belongsTo(StorageLocation::class, 'storageLocationId');
    }

    /**
     * POST /activate
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function activate(array $params = []): ?array
    {
        return $this->newQuery()->callAction('activate', $params, 'POST');
    }

    /**
     * POST /deactivate
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function deactivate(array $params = []): ?array
    {
        return $this->newQuery()->callAction('deactivate', $params, 'POST');
    }
}
