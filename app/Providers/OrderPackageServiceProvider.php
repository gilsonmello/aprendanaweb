<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class OrderPackageServiceProvider
 * @package App\Providers
 */
class OrderPackageServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\OrderPackage\OrderPackageContract',
            'App\Repositories\Backend\OrderPackage\EloquentOrderPackageRepository'
        );
    }
}