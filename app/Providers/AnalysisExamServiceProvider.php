<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AnalysisExamServiceProvider
 * @package App\Providers
 */
class AnalysisExamServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\AnalysisExam\AnalysisExamContract',
            'App\Repositories\Backend\AnalysisExam\EloquentAnalysisExamRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\AnalysisExam\AnalysisExamContract',
            'App\Repositories\Frontend\AnalysisExam\EloquentAnalysisExamRepository'
        );
    }
}