<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class CourseServiceProvider
 * @package App\Providers
 */
class CourseServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Course\CourseContract',
            'App\Repositories\Backend\Course\EloquentCourseRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Course\CourseContract',
            'App\Repositories\Frontend\Course\EloquentCourseRepository'
        );

        $this->app->bind(
            'App\Repositories\Backend\CourseContent\CourseContentContract',
            'App\Repositories\Backend\CourseContent\EloquentCourseContentRepository'
        );
    }
}