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
    public static function currentAttendance(array $params = []): ?array
    {
        return (new self)->newQuery()->action('currentAttendance', $params, 'GET');
    }

    /**
     * POST /logOff
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public static function logOff(array $params = []): ?array
    {
        return (new self)->newQuery()->action('logOff', $params, 'POST');
    }

    /**
     * POST /logOn
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public static function logOn(array $params = []): ?array
    {
        return (new self)->newQuery()->action('logOn', $params, 'POST');
    }
}
