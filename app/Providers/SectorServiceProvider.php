<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class SectorServiceProvider
 * @package App\Providers
 */
class SectorServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Sector\SectorContract',
            'App\Repositories\Backend\Sector\EloquentSectorRepository'
        );
    }
}