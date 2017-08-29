<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class WorkshopEvaluationGroupServiceProvider
 * @package App\Providers
 */
class WorkshopEvaluationGroupServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\WorkshopEvaluationGroup\WorkshopEvaluationGroupContract',
            'App\Repositories\Backend\WorkshopEvaluationGroup\EloquentWorkshopEvaluationGroupRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\WorkshopEvaluationGroup\WorkshopEvaluationGroupContract',
            'App\Repositories\Frontend\WorkshopEvaluationGroup\EloquentWorkshopEvaluationGroupRepository'
        );
    }
}