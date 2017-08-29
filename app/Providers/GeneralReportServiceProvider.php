<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GeneralReportServiceProvider extends ServiceProvider {

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
			'App\Repositories\Backend\GeneralReport\GeneralReportContract',
			'App\Repositories\Backend\GeneralReport\EloquentGeneralReportRepository'
		);

	}
}