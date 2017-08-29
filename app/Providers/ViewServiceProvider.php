<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ViewServiceProvider
 * @package App\Providers
 */
class ViewServiceProvider extends ServiceProvider
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
            'App\Repositories\Frontend\View\ViewContract',
            'App\Repositories\Frontend\View\EloquentViewRepository'
        );

        $this->app->bind(
            'App\Repositories\Backend\View\ViewContract',
            'App\Repositories\Backend\View\EloquentViewRepository'
        );
    }
}