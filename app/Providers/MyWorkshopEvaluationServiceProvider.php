<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class MyWorkshopEvaluationServiceProvider
 * @package App\Providers
 */
class MyWorkshopEvaluationServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\MyWorkshopEvaluation\MyWorkshopEvaluationContract',
            'App\Repositories\Backend\MyWorkshopEvaluation\EloquentMyWorkshopEvaluationRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\MyWorkshopEvaluation\MyWorkshopEvaluationContract',
            'App\Repositories\Frontend\MyWorkshopEvaluation\EloquentMyWorkshopEvaluationRepository'
        );
    }
}