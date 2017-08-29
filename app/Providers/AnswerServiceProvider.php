<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AnswerServiceProvider
 * @package App\Providers
 */
class AnswerServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Answer\AnswerContract',
            'App\Repositories\Backend\Answer\EloquentAnswerRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Answer\AnswerContract',
            'App\Repositories\Frontend\Answer\EloquentAnswerRepository'
        );
    }
}