<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class OrderLessonServiceProvider
 * @package App\Providers
 */
class OrderLessonServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\OrderLesson\OrderLessonContract',
            'App\Repositories\Backend\OrderLesson\EloquentOrderLessonRepository'
        );
    }
}