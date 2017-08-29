<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class OrderCourseServiceProvider
 * @package App\Providers
 */
class OrderCourseServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\OrderCourse\OrderCourseContract',
            'App\Repositories\Backend\OrderCourse\EloquentOrderCourseRepository'
        );
    }
}