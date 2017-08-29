<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class PackageServiceProvider
 * @package App\Providers
 */
class PackageServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Package\PackageContract',
            'App\Repositories\Backend\Package\EloquentPackageRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\Package\PackageContract',
            'App\Repositories\Frontend\Package\EloquentPackageRepository'
        );
        $this->app->bind(
            'App\Repositories\Backend\PackageExam\PackageExamContract',
            'App\Repositories\Backend\PackageExam\EloquentPackageExamRepository'
        );
    }
}