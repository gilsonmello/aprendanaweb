<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider {

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
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
			'App\Repositories\Backend\Notification\NotificationContract',
			'App\Repositories\Backend\Notification\EloquentNotificationRepository'
		);

	}
}