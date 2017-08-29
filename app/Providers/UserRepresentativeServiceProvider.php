<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class UserRepresentativeServiceProvider
 * @package App\Providers
 */
class UserRepresentativeServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\User\UserRepresentativeContract',
            'App\Repositories\Backend\User\EloquentUserRepresentativeRepository'
        );


    }
}