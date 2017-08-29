<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ViewExamServiceProvider
 * @package App\Providers
 */
class ViewExamServiceProvider extends ServiceProvider
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
            'App\Repositories\Frontend\ViewExam\ViewExamContract',
            'App\Repositories\Frontend\ViewExam\EloquentViewExamRepository'
        );

//        $this->app->bind(
//            'App\Repositories\Backend\ViewExam\ViewExamContract',
//            'App\Repositories\Backend\ViewExam\EloquentViewExamRepository'
//        );
    }
}