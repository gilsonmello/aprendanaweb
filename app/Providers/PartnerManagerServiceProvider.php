<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class PartnerServiceProvider
 * @package App\Providers
 */
class PartnerManagerServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\PartnerManager\PartnerManagerContract',
            'App\Repositories\Backend\PartnerManager\EloquentPartnerManagerRepository'
        );
    }
}