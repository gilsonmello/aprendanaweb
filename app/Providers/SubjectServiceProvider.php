<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class SubjectServiceProvider
 * @package App\Providers
 */
class SubjectServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Subject\SubjectContract',
            'App\Repositories\Backend\Subject\EloquentSubjectRepository'
        );
        $this->app->bind(
            'App\Repositories\Backend\SubjectCourse\SubjectCourseContract',
            'App\Repositories\Backend\SubjectCourse\EloquentSubjectCourseRepository'
        );
        $this->app->bind(
            'App\Repositories\Backend\SubjectPackage\SubjectPackageContract',
            'App\Repositories\Backend\SubjectPackage\EloquentSubjectPackageRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Subject\SubjectContract',
            'App\Repositories\Frontend\Subject\EloquentSubjectRepository'
        );
    }
}