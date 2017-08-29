<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class PartnerServiceProvider
 * @package App\Providers
 */
class PartnerServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Partner\PartnerContract',
            'App\Repositories\Backend\Partner\EloquentPartnerRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Partner\PartnerContract',
            'App\Repositories\Frontend\Partner\EloquentPartnerRepository'
        );
    }
}