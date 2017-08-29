<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class SliderServiceProvider
 * @package App\Providers
 */
class SliderServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Slider\SliderContract',
            'App\Repositories\Backend\Slider\EloquentSliderRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Slider\SliderContract',
            'App\Repositories\Frontend\Slider\EloquentSliderRepository'
        );
    }
}