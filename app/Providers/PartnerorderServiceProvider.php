<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class PartnerorderServiceProvider
 * @package App\Providers
 */
class PartnerorderServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Partnerorder\PartnerorderContract',
            'App\Repositories\Backend\Partnerorder\EloquentPartnerorderRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Partnerorder\PartnerorderContract',
            'App\Repositories\Frontend\Partnerorder\EloquentPartnerorderRepository'
        );
        $this->app->bind(
            'App\Repositories\Backend\PartnerorderPayment\PartnerorderPaymentContract',
            'App\Repositories\Backend\PartnerorderPayment\EloquentPartnerorderPaymentRepository'
        );
    }
}