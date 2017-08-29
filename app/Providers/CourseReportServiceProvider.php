<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class StateServiceProvider
 * @package App\Providers
 */
class CourseReportServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Report\CourseReportContract',
            'App\Repositories\Backend\Report\EloquentCourseReportRepository'
        );
    }
}