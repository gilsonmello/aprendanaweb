<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AnalysisServiceProvider
 * @package App\Providers
 */
class AnalysisServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Analysis\AnalysisContract',
            'App\Repositories\Backend\Analysis\EloquentAnalysisRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Analysis\AnalysisContract',
            'App\Repositories\Frontend\Analysis\EloquentAnalysisRepository'
        );
    }
}