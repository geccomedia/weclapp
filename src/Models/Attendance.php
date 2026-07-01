<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\AttendanceBreak;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property list<AttendanceBreak>|null $breaks
 * @property Carbon|null $endTime
 * @property Carbon|null $startTime
 * @property string|null $userId
 */
class Attendance extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'breaks' => AttendanceBreak::class,
    ];

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

    /**
     * POST /endBreak
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function endBreak(array $params = []): ?array
    {
        return $this->callAction('endBreak', $params, 'POST');
    }

    /**
     * POST /startBreak
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function startBreak(array $params = []): ?array
    {
        return $this->callAction('startBreak', $params, 'POST');
    }
}
