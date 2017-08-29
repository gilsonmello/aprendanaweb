<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class OfficeServiceProvider
 * @package App\Providers
 */
class OfficeServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Office\OfficeContract',
            'App\Repositories\Backend\Office\EloquentOfficeRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Office\OfficeContract',
            'App\Repositories\Frontend\Office\EloquentOfficeRepository'
        );
    }
}