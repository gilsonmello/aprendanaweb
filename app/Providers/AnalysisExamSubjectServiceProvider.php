<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AnalysisExamSubjectServiceProvider
 * @package App\Providers
 */
class AnalysisExamSubjectServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\AnalysisExamSubject\AnalysisExamSubjectContract',
            'App\Repositories\Backend\AnalysisExamSubject\EloquentAnalysisExamSubjectRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\AnalysisExamSubject\AnalysisExamSubjectContract',
            'App\Repositories\Frontend\AnalysisExamSubject\EloquentAnalysisExamSubjectRepository'
        );
    }
}