<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class CityServiceProvider
 * @package App\Providers
 */
class CityServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\City\CityContract',
            'App\Repositories\Backend\City\EloquentCityRepository'
        );
    }
}