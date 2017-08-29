<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class CourseCalendarServiceProvider
 * @package App\Providers
 */
class CourseCalendarServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\CourseCalendar\CourseCalendarContract',
            'App\Repositories\Backend\CourseCalendar\EloquentCourseCalendarRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\CourseCalendar\CourseCalendarContract',
            'App\Repositories\Frontend\CourseCalendar\EloquentCourseCalendarRepository'
        );
    }
}