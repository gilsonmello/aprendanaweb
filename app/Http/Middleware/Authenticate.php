<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
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

		if ($this->auth->guest()) {
			if ($request->ajax()) {
				return response('Unauthorized.', 401);
			} else {

				if ($request->route()->getPrefix() == "/admin") {
					return redirect()->guest('admin/auth/login');
				} else {
					return redirect()->guest('/auth/login');
				}
			}
		}
		//}else if(Auth::user()->last_session_id != \Session::getId()){
       //             return redirect()->intended('/endsession');
       //}


		Log::info('Informação do authenticate: ' . $request);
		return $next($request);
	}
}
