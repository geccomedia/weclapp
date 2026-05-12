<?php

namespace Geccomedia\Weclapp;

use GuzzleHttp\Psr7\Request;

/**
 * Typed wrapper around the Weclapp /system/* utility endpoints.
 *
 * These endpoints have no CRUD model and cannot be queried through the normal
 * Builder/Model API. This class resolves the Connection from the service
 * container and exposes each endpoint as a named method.
 *
 * Usage:
 *
 *   use Geccomedia\Weclapp\SystemApi;
 *
 *   $perms    = app(SystemApi::class)->permissions();
 *   $licenses = app(SystemApi::class)->licenses();
 *   $info     = app(SystemApi::class)->demoTestSystemInfo();
 *   app(SystemApi::class)->createDemoTestSystem('My Test', 'PROD_SYSTEM');
 */
class SystemApi
{
    public function __construct(protected Connection $connection) {}

    /**
     * GET /system/permissions
     *
     * Returns the list of permission slugs granted to the current API key.
     *
     * @return string[]
     */
    public function permissions(): array
    {
        $result = $this->connection->selectRequest(new Request('GET', 'system/permissions'));

        return is_array($result) ? $result : [];
    }

    /**
     * GET /system/licenses
     *
     * Returns the active licence modules and their included permissions.
     *
     * @return array<int, array{name: string, permissions: string[]}>
     */
    public function licenses(): array
    {
        $result = $this->connection->selectRequest(new Request('GET', 'system/licenses'));

        return is_array($result) ? $result : [];
    }

    /**
     * GET /system/demoTestSystemInfo
     *
     * Returns information about whether a demo instance can be created from this tenant.
     *
     * @return array{createPossible: bool, creationInProgress: bool, demoInstanceUrl: string|null, mainInstanceUrl: string|null}|null
     */
    public function demoTestSystemInfo(): ?array
    {
        $body = $this->connection->action(new Request('GET', 'system/demoTestSystemInfo'));

        return $body['result'] ?? null;
    }

    /**
     * POST /system/createDemoTestSystem
     *
     * Creates a demo copy of this tenant. The preset must be one of:
     * 'NONE', 'PROD_SYSTEM', or 'TEMPLATE_SYSTEM'.
     *
     * @param  string  $label  A human-readable label for the new demo system.
     * @param  string  $preset  One of 'NONE', 'PROD_SYSTEM', 'TEMPLATE_SYSTEM'.
     * @param  bool  $allUsers  Whether to copy all users to the demo system (optional, default false).
     * @return array<mixed>|null
     */
    public function createDemoTestSystem(string $label, string $preset, bool $allUsers = false): ?array
    {
        $body = json_encode([
            'label' => $label,
            'preset' => $preset,
            'allUsers' => $allUsers,
        ]);

        return $this->connection->action(new Request('POST', 'system/createDemoTestSystem', [], $body));
    }
}
