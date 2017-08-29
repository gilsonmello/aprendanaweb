<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class FaqServiceProvider
 * @package App\Providers
 */
class FaqServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Faq\FaqContract',
            'App\Repositories\Backend\Faq\EloquentFaqRepository'
        );
    }
}