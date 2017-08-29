<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ArticleServiceProvider
 * @package App\Providers
 */
class ArticleServiceProvider extends ServiceProvider
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
            'App\Repositories\Frontend\Article\ArticleContract',
            'App\Repositories\Frontend\Article\EloquentArticleRepository'
        );

        $this->app->bind(
            'App\Repositories\Backend\Article\ArticleContract',
            'App\Repositories\Backend\Article\EloquentArticleRepository'
        );
    }
}