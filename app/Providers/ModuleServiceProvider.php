<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ModuleServiceProvider
 * @package App\Providers
 */
class ModuleServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Module\ModuleContract',
            'App\Repositories\Backend\Module\EloquentModuleRepository'
        );

        $this->app->bind(
            'App\Repositories\Frontend\Module\ModuleContract',
            'App\Repositories\Frontend\Module\EloquentModuleRepository'
        );
    }
}