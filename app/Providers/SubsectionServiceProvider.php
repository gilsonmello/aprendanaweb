<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class SubsectionServiceProvider
 * @package App\Providers
 */
class SubsectionServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Subsection\SubsectionContract',
            'App\Repositories\Backend\Subsection\EloquentSubsectionRepository'
        );


        $this->app->bind(
            'App\Repositories\Frontend\Subsection\SubsectionContract',
            'App\Repositories\Frontend\Subsection\EloquentSubsectionRepository'
        );
    }
}