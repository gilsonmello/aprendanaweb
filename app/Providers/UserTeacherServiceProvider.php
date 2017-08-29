<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class UserTeacherServiceProvider
 * @package App\Providers
 */
class UserTeacherServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\User\UserTeacherContract',
            'App\Repositories\Backend\User\EloquentUserTeacherRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\User\UserTeacherContract',
            'App\Repositories\Frontend\User\EloquentUserTeacherRepository'
        );
    }
}