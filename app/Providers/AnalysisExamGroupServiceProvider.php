<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AnalysisExamGroupServiceProvider
 * @package App\Providers
 */
class AnalysisExamGroupServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\AnalysisExamGroup\AnalysisExamGroupContract',
            'App\Repositories\Backend\AnalysisExamGroup\EloquentAnalysisExamGroupRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\AnalysisExamGroup\AnalysisExamGroupContract',
            'App\Repositories\Frontend\AnalysisExamGroup\EloquentAnalysisExamGroupRepository'
        );
    }
}