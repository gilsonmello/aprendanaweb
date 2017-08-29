<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class NewsServiceProvider
 * @package App\Providers
 */
class NewsServiceProvider extends ServiceProvider
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
            'App\Repositories\Frontend\News\NewsContract',
            'App\Repositories\Frontend\News\EloquentNewsRepository'
        );

        $this->app->bind(
            'App\Repositories\Backend\News\NewsContract',
            'App\Repositories\Backend\News\EloquentNewsRepository'
        );
    }
}