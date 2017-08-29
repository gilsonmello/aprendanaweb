<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class NewsServiceProvider
 * @package App\Providers
 */
class SupplierServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Supplier\SupplierContract',
            'App\Repositories\Backend\Supplier\EloquentSupplierRepository'
        );
    }
}