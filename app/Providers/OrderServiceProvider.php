<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class OrderServiceProvider
 * @package App\Providers
 */
class OrderServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Order\OrderContract',
            'App\Repositories\Backend\Order\EloquentOrderRepository'
        );
    }
}