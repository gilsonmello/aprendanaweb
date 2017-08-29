<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ContentsCommentsServiceProvider
 * @package App\Providers
 */
class QuestionNoteServiceProvider extends ServiceProvider
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
            'App\Repositories\Frontend\QuestionNote\QuestionNoteContract',
            'App\Repositories\Frontend\QuestionNote\EloquentQuestionNoteRepository'
        );
    }
}