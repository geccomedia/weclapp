<?php

namespace Geccomedia\Weclapp;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;

/**
 * Typed wrapper around the Weclapp /job/* utility endpoints.
 *
 * Weclapp runs long-running background jobs asynchronously. You can poll
 * or abort them by job type using this class.
 *
 * Usage:
 *
 *   use Geccomedia\Weclapp\JobApi;
 *
 *   $status = app(JobApi::class)->status('INVENTORY_BOOKING');
 *   app(JobApi::class)->abort('INVENTORY_BOOKING');
 */
class JobApi
{
    public function __construct(protected Connection $connection) {}

    /**
     * GET /job/status?type={type}
     *
     * Returns the current status and progress of the named background job.
     *
     * Valid type values are the SCREAMING_SNAKE_CASE job names listed in the
     * Weclapp API spec (e.g. 'INVENTORY_BOOKING', 'MATERIAL_PLANNING_RUN',
     * 'MASS_SHIPMENT_CREATION', 'ACCOUNTING_EXPORT', etc.).
     *
     * @param  string  $type  The job type identifier.
     * @return array{type: string, status: string, progress: array{current: int, total: int}|null}|null
     */
    public function status(string $type): ?array
    {
        $uri = (string) Uri::withQueryValues(new Uri('job/status'), ['type' => $type]);
        $body = $this->connection->action(new Request('GET', $uri));

        return $body['result'] ?? null;
    }

    /**
     * GET /job/abort?type={type}
     *
     * Requests cancellation of a running background job.
     *
     * Valid type values are the SCREAMING_SNAKE_CASE job names listed in the
     * Weclapp API spec (e.g. 'INVENTORY_BOOKING', 'MATERIAL_PLANNING_RUN', etc.).
     *
     * @param  string  $type  The job type identifier.
     * @return array{type: string, status: string, progress: array{current: int, total: int}|null}|null
     */
    public function abort(string $type): ?array
    {
        $uri = (string) Uri::withQueryValues(new Uri('job/abort'), ['type' => $type]);
        $body = $this->connection->action(new Request('GET', $uri));

        return $body['result'] ?? null;
    }
}
