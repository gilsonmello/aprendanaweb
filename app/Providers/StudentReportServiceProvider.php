<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class StateServiceProvider
 * @package App\Providers
 */
class StudentReportServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Report\StudentReportContract',
            'App\Repositories\Backend\Report\EloquentStudentReportRepository'
        );
    }
}