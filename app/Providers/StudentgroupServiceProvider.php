<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class StudentgroupServiceProvider
 * @package App\Providers
 */
class StudentgroupServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Studentgroup\StudentgroupContract',
            'App\Repositories\Backend\Studentgroup\EloquentStudentgroupRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Studentgroup\StudentgroupContract',
            'App\Repositories\Frontend\Studentgroup\EloquentStudentgroupRepository'
        );
    }
}