<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class TicketServiceProvider
 * @package App\Providers
 */
class TicketServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Ticket\TicketContract',
            'App\Repositories\Backend\Ticket\EloquentTicketRepository'
        );
    }
}