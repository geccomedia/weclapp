<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\ServiceQuotaRelationship;
use Geccomedia\Weclapp\SubModels\ServiceQuotaStatusHistory;
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
}
