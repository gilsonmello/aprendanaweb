<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class VideoServiceProvider
 * @package App\Providers
 */
class VideoServiceProvider extends ServiceProvider
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
            'App\Repositories\Frontend\Video\VideoContract',
            'App\Repositories\Frontend\Video\EloquentVideoRepository'
        );

        $this->app->bind(
            'App\Repositories\Backend\Video\VideoContract',
            'App\Repositories\Backend\Video\EloquentVideoRepository'
        );
    }
}