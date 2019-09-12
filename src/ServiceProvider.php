<?php
namespace Geccomedia\Weclapp;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @throws \Exception
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/accounting.php', 'accounting');
    }

    public function boot()
    {
        $this->publishes([__DIR__.'/../config/accounting.php' => config_path('accounting.php')], 'config');
    }
}
