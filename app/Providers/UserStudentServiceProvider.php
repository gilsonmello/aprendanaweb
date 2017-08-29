<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class UserStudentServiceProvider
 * @package App\Providers
 */
class UserStudentServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\User\UserStudentContract',
            'App\Repositories\Backend\User\EloquentUserStudentRepository'
        );


    }
}