<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class WorkshopActivityServiceProvider
 * @package App\Providers
 */
class WorkshopActivityServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\WorkshopActivity\WorkshopActivityContract',
            'App\Repositories\Backend\WorkshopActivity\EloquentWorkshopActivityRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\WorkshopActivity\WorkshopActivityContract',
            'App\Repositories\Frontend\WorkshopActivity\EloquentWorkshopActivityRepository'
        );


    }
}