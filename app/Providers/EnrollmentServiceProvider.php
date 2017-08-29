<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class EnrollmentServiceProvider
 * @package App\Providers
 */
class EnrollmentServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Enrollment\EnrollmentContract',
            'App\Repositories\Backend\Enrollment\EloquentEnrollmentRepository'
        );

        $this->app->bind(
            'App\Repositories\Frontend\Enrollment\EnrollmentContract',
            'App\Repositories\Frontend\Enrollment\EloquentEnrollmentRepository'
        );
    }
}