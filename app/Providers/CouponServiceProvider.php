<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class CouponServiceProvider
 * @package App\Providers
 */
class CouponServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Coupon\CouponContract',
            'App\Repositories\Backend\Coupon\EloquentCouponRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Coupon\CouponContract',
            'App\Repositories\Frontend\Coupon\EloquentCouponRepository'
        );
    }
}