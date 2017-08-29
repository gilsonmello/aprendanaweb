<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ContentsCommentsServiceProvider
 * @package App\Providers
 */
class ContentsCommentsServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Content\ContentContract',
            'App\Repositories\Backend\Content\EloquentContentRepository'
        );

        $this->app->bind(
            'App\Repositories\Backend\ContentsComments\ContentsCommentsContract',
            'App\Repositories\Backend\ContentsComments\EloquentContentsCommentsRepository'


        );
        $this->app->bind(
            'App\Repositories\Frontend\ContentComments\ContentCommentsContract',
            'App\Repositories\Frontend\ContentComments\EloquentContentCommentsRepository'
        );
    }
}