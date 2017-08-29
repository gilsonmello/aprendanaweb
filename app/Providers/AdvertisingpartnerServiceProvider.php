<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AdvertisingpartnerServiceProvider
 * @package App\Providers
 */
class AdvertisingpartnerServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Advertisingpartner\AdvertisingpartnerContract',
            'App\Repositories\Backend\Advertisingpartner\EloquentAdvertisingpartnerRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Advertisingpartner\AdvertisingpartnerContract',
            'App\Repositories\Frontend\Advertisingpartner\EloquentAdvertisingpartnerRepository'
        );
    }
}