<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class LessonServiceProvider
 * @package App\Providers
 */
class LessonServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Lesson\LessonContract',
            'App\Repositories\Backend\Lesson\EloquentLessonRepository'
        );

        $this->app->bind(
            'App\Repositories\Frontend\Lesson\LessonContract',
            'App\Repositories\Frontend\Lesson\EloquentLessonRepository'
        );
    }
}