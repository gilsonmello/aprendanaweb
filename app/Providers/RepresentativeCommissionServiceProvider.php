<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class CouponServiceProvider
 * @package App\Providers
 */
class RepresentativeCommissionServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\RepresentativeCommission\RepresentativeCommissionContract',
            'App\Repositories\Backend\RepresentativeCommission\EloquentRepresentativeCommissionRepository'
        );
    }
}