<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class WorkshopCriteriaServiceProvider
 * @package App\Providers
 */
class WorkshopCriteriaServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\WorkshopCriteria\WorkshopCriteriaContract',
            'App\Repositories\Backend\WorkshopCriteria\EloquentWorkshopCriteriaRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\WorkshopCriteria\WorkshopCriteriaContract',
            'App\Repositories\Frontend\WorkshopCriteria\EloquentWorkshopCriteriaRepository'
        );
    }
}