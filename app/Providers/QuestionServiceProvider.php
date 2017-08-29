<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class QuestionServiceProvider
 * @package App\Providers
 */
class QuestionServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Question\QuestionContract',
            'App\Repositories\Backend\Question\EloquentQuestionRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Question\QuestionContract',
            'App\Repositories\Frontend\Question\EloquentQuestionRepository'
        );
    }
}