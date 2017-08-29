<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class CourseAlertServiceProvider
 * @package App\Providers
 */
class CourseAlertServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\CourseAlert\CourseAlertContract',
            'App\Repositories\Backend\CourseAlert\EloquentCourseAlertRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\CourseAlert\CourseAlertContract',
            'App\Repositories\Frontend\CourseAlert\EloquentCourseAlertRepository'
        );
    }
}