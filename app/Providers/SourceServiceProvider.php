<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class SourceServiceProvider
 * @package App\Providers
 */
class SourceServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Source\SourceContract',
            'App\Repositories\Backend\Source\EloquentSourceRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Source\SourceContract',
            'App\Repositories\Frontend\Source\EloquentSourceRepository'
        );
    }
}