<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {


	/**
	 * @param $request
	 * @return bool
     */
	protected function excludedRoutes($request)
	{
		$routes = [
			'pagseguro/feedback'
		];

		foreach($routes as $route)
			if ($request->is($route))
				return true;

		return false;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($this->isReading($request) || $this->excludedRoutes($request) || $this->tokensMatch($request)) {
			return $this->addCookieToResponse($request, $next($request));
		}

		return redirect("/")->with("alert", "A sua sessão expirou ou foi feita um acesso inválido.");
	}

}
