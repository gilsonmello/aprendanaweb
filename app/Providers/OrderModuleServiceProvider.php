<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class OrderModuleServiceProvider
 * @package App\Providers
 */
class OrderModuleServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\OrderModule\OrderModuleContract',
            'App\Repositories\Backend\OrderModule\EloquentOrderModuleRepository'
        );
    }
}