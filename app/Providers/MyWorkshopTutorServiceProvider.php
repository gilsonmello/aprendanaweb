<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class MyWorkshopTutorServiceProvider
 * @package App\Providers
 */
class MyWorkshopTutorServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\MyWorkshopTutor\MyWorkshopTutorContract',
            'App\Repositories\Backend\MyWorkshopTutor\EloquentMyWorkshopTutorRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\MyWorkshopTutor\MyWorkshopTutorContract',
            'App\Repositories\Frontend\MyWorkshopTutor\EloquentMyWorkshopTutorRepository'
        );
    }
}