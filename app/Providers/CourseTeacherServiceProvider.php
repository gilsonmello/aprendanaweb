<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class CourseTeacherServiceProvider
 * @package App\Providers
 */
class CourseTeacherServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\CourseTeacher\CourseTeacherContract',
            'App\Repositories\Backend\CourseTeacher\EloquentCourseTeacherRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\CourseTeacher\CourseTeacherContract',
            'App\Repositories\Frontend\CourseTeacher\EloquentCourseTeacherRepository'
        );
    }
}