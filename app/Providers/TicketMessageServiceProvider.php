<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class TicketMessageServiceProvider
 * @package App\Providers
 */
class TicketMessageServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\TicketMessage\TicketMessageContract',
            'App\Repositories\Backend\TicketMessage\EloquentTicketMessageRepository'
        );
    }
}