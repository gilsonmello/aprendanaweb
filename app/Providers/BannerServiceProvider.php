<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class BannerServiceProvider
 * @package App\Providers
 */
class BannerServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Banner\BannerContract',
            'App\Repositories\Backend\Banner\EloquentBannerRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Banner\BannerContract',
            'App\Repositories\Frontend\Banner\EloquentBannerRepository'
        );
    }
}