<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class WorkshopTutorServiceProvider
 * @package App\Providers
 */
class WorkshopTutorServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\WorkshopTutor\WorkshopTutorContract',
            'App\Repositories\Backend\WorkshopTutor\EloquentWorkshopTutorRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\WorkshopTutor\WorkshopTutorContract',
            'App\Repositories\Frontend\WorkshopTutor\EloquentWorkshopTutorRepository'
        );
    }
}