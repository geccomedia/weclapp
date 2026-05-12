<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string|null $connectionType
 * @property string|null $name
 */
class ExternalConnection extends Model
{
    protected bool $creatable = false;

    protected bool $deletable = false;

    /**
     * POST /startArticleSynchronization
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function startArticleSynchronization(array $params = []): ?array
    {
        return $this->newQuery()->callAction('startArticleSynchronization', $params, 'POST');
    }

    /**
     * POST /startEbayListingSynchronization
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function startEbayListingSynchronization(array $params = []): ?array
    {
        return $this->newQuery()->callAction('startEbayListingSynchronization', $params, 'POST');
    }

    /**
     * POST /startOrderSynchronization
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function startOrderSynchronization(array $params = []): ?array
    {
        return $this->newQuery()->callAction('startOrderSynchronization', $params, 'POST');
    }
}
