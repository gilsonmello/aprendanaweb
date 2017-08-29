<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class WorkshopServiceProvider
 * @package App\Providers
 */
class WorkshopServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Workshop\WorkshopContract',
            'App\Repositories\Backend\Workshop\EloquentWorkshopRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Workshop\WorkshopContract',
            'App\Repositories\Frontend\Workshop\EloquentWorkshopRepository'
        );
    }
}