<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ConfigurationServiceProvider
 * @package App\Providers
 */
class ConfigurationServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Register service provider bindings
     */
    public function registerBindings() {
        $this->app->bind(
            'App\Repositories\Backend\Configuration\ConfigurationContract',
            'App\Repositories\Backend\Configuration\EloquentConfigurationRepository'
        );
    }
}