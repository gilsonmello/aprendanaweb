<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class NewsServiceProvider
 * @package App\Providers
 */
class ProductServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Product\ProductContract',
            'App\Repositories\Backend\Product\EloquentProductRepository'
        );
    }
}