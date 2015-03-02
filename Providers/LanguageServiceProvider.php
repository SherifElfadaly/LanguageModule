<?php
namespace App\Modules\Language\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider
{
	/**
	 * Register the Language module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Language\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the Language module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('language', __DIR__.'/../Resources/Lang/');

		View::addNamespace('language', __DIR__.'/../Resources/Views/');
	}
}
