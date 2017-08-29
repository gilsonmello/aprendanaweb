<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class TeacherServiceProvider
 * @package App\Providers
 */
class TeacherServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Teacher\TeacherContract',
            'App\Repositories\Backend\Teacher\EloquentTeacherRepository'
        );
        $this->app->bind(
            'App\Repositories\Backend\TeacherStatement\TeacherStatementContract',
            'App\Repositories\Backend\TeacherStatement\EloquentTeacherStatementRepository'
        );
    }
}