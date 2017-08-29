<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class PackageTeacherServiceProvider
 * @package App\Providers
 */
class PackageTeacherServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\PackageTeacher\PackageTeacherContract',
            'App\Repositories\Backend\PackageTeacher\EloquentPackageTeacherRepository'
        );
        $this->app->bind(
            'App\Repositories\Frontend\PackageTeacher\PackageTeacherContract',
            'App\Repositories\Frontend\PackageTeacher\EloquentPackageTeacherRepository'
        );
    }
}