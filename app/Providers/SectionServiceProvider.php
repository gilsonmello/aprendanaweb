<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class SectionServiceProvider
 * @package App\Providers
 */
class SectionServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Section\SectionContract',
            'App\Repositories\Backend\Section\EloquentSectionRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Section\SectionContract',
            'App\Repositories\Frontend\Section\EloquentSectionRepository'
        );
    }
}