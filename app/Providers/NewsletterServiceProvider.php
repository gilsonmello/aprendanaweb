<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class NewsletterServiceProvider
 * @package App\Providers
 */
class NewsletterServiceProvider extends ServiceProvider
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
            'App\Repositories\Backend\Newsletter\NewsletterContract',
            'App\Repositories\Backend\Newsletter\EloquentNewsletterRepository'
        );

        $this->app->bind(
            'App\Repositories\Frontend\Newsletter\NewsletterContract',
            'App\Repositories\Frontend\Newsletter\EloquentNewsletterRepository'
        );
    }
}