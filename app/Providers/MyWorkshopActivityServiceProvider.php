<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class MyWorkshopActivityServiceProvider
 * @package App\Providers
 */
class MyWorkshopActivityServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\MyWorkshopActivity\MyWorkshopActivityContract',
            'App\Repositories\Backend\MyWorkshopActivity\EloquentMyWorkshopActivityRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\MyWorkshopActivity\MyWorkshopActivityContract',
            'App\Repositories\Frontend\MyWorkshopActivity\EloquentMyWorkshopActivityRepository'
        );

        $this->app->bind(
            'App\Repositories\Frontend\WorkshopActivity\MyWorkshopActivityTimeContract',
            'App\Repositories\Frontend\WorkshopActivity\EloquentMyWorkshopActivityTimeRepository'
        );
    }
}