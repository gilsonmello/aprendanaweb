<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class InstitutionServiceProvider
 * @package App\Providers
 */
class InstitutionServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Institution\InstitutionContract',
            'App\Repositories\Backend\Institution\EloquentInstitutionRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Institution\InstitutionContract',
            'App\Repositories\Frontend\Institution\EloquentInstitutionRepository'
        );
    }
}