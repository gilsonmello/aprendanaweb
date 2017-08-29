<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class WorkshopGroupTutorServiceProvider
 * @package App\Providers
 */
class WorkshopGroupTutorServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Webinar\WebinarContract',
            'App\Repositories\Backend\Webinar\EloquentWebinarRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\WorkshopGroupTutor\WorkshopGroupTutorContract',
            'App\Repositories\Frontend\WorkshopGroupTutor\EloquentWorkshopGroupTutorRepository'
        );
    }
}