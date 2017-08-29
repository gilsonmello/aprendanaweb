<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class OccupationServiceProvider
 * @package App\Providers
 */
class OccupationServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Occupation\OccupationContract',
            'App\Repositories\Backend\Occupation\EloquentOccupationRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Occupation\OccupationContract',
            'App\Repositories\Frontend\Occupation\EloquentOccupationRepository'
        );
    }
}