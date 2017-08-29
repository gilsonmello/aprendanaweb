<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class FaqCategoryServiceProvider
 * @package App\Providers
 */
class FaqCategoryServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\FaqCategory\FaqCategoryContract',
            'App\Repositories\Backend\FaqCategory\EloquentFaqCategoryRepository'
        );
    }
}