<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class PreenrollmentServiceProvider
 * @package App\Providers
 */
class PreenrollmentServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Preenrollment\PreenrollmentContract',
            'App\Repositories\Backend\Preenrollment\EloquentPreenrollmentRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Preenrollment\PreenrollmentContract',
            'App\Repositories\Frontend\Preenrollment\EloquentPreenrollmentRepository'
        );
    }
}