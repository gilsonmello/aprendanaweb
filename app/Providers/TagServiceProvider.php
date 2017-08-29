<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class TagServiceProvider
 * @package App\Providers
 */
class TagServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Tag\TagContract',
            'App\Repositories\Backend\Tag\EloquentTagRepository'
        );
    }
}