<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\ServiceQuotaRelationship;
use Geccomedia\Weclapp\SubModels\ServiceQuotaStatusHistory;
use Geccomedia\Weclapp\Traits\NoCreate;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $articleId
 * @property int|null $billableQuantitySeconds
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $customerId
 * @property string|null $description
 * @property string|null $name
 * @property int|null $quantitySeconds
 * @property string|null $serviceQuotaNumber
 * @property list<ServiceQuotaRelationship>|null $serviceQuotaRelationships
 * @property string|null $status
 * @property list<ServiceQuotaStatusHistory>|null $statusHistory
 * @property Carbon|null $validFromDate
 * @property Carbon|null $validUntilDate
 */
class ServiceQuota extends Model
{
    use NoCreate;

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customAttributes' => CustomAttribute::class,
        'serviceQuotaRelationships' => ServiceQuotaRelationship::class,
        'statusHistory' => ServiceQuotaStatusHistory::class,
    ];

    /**
     * @return BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'articleId');
    }

    /**
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Party::class, 'customerId');
    }

    /**
     * POST /close
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function close(array $params = []): ?array
    {
        return $this->callAction('close', $params, 'POST');
    }

    /**
     * POST /createPerformanceRecord
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPerformanceRecord(array $params = []): ?array
    {
        return $this->callAction('createPerformanceRecord', $params, 'POST');
    }

    /**
     * POST /open
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function open(array $params = []): ?array
    {
        return $this->callAction('open', $params, 'POST');
    }
}
