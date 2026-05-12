<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Carbon|null $endTime
 * @property Carbon|null $startTime
 * @property string|null $userId
 */
class Attendance extends Model
{
    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    /**
     * GET /currentAttendance
     *
     * @param  array<string,mixed>  $params  Query parameters forwarded to the API.
     * @return array<mixed>|null
     */
    public function currentAttendance(array $params = []): ?array
    {
        return $this->callAction('currentAttendance', $params, 'GET');
    }

    /**
     * POST /logOff
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function logOff(array $params = []): ?array
    {
        return $this->callAction('logOff', $params, 'POST');
    }

    /**
     * POST /logOn
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function logOn(array $params = []): ?array
    {
        return $this->callAction('logOn', $params, 'POST');
    }
}
