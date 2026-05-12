<?php

namespace Geccomedia\Weclapp\Tests\Concerns;

use Geccomedia\Weclapp\ServiceProvider;

/**
 * Registers the Weclapp service provider with the Orchestra test application.
 *
 * Used by every OrchestraTestCase subclass instead of repeating the
 * getPackageProviders() boilerplate in each file.
 */
trait UsesServiceProvider
{
    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }
}
