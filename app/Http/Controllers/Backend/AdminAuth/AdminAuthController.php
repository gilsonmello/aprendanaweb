<?php namespace App\Http\Controllers\Backend\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Repositories\Backend\Auth\AuthenticationContract;
use App\Http\Requests\Frontend\Access\LoginRequest;
use App\Http\Requests\Frontend\Access\RegisterRequest;
use App\Exceptions\GeneralException;

/**
 * Class AuthController
 * @package App\Http\Controllers\Frontend\Auth
 */
class AdminAuthController extends Controller {

	use ThrottlesLogins;

	/**
	 * @param AuthenticationContract $auth
	 */
	public function __construct(AuthenticationContract $auth)
	{

		$this->auth = $auth;
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function getRegister() {
		return view('backend.auth.register');
	}

	/**
	 * @param RegisterRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postRegister(RegisterRequest $request)
	{
		if (config('access.users.confirm_email')) {
			$this->auth->create($request->all());
			return redirect()->route('home')->withFlashSuccess("Your account was successfully created. We have sent you an e-mail to confirm your account.");
		} else {
			//Use native auth login because do not need to check status when registering
			auth()->login($this->auth->create($request->all()));
			return redirect()->route('backend.dashboard');
		}
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function getLogin() {
		return view('backend.auth.login');
	}

	/**
	 * @param LoginRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postLogin(LoginRequest $request)
	{
		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		$throttles = $this->isUsingThrottlesLoginsTrait();


		if ($throttles && $this->hasTooManyLoginAttempts($request)) {
			return $this->sendLockoutResponse($request);
		}

		//Don't know why the exception handler is not catching this
		try {
			$this->auth->login($request);

			if ($throttles) {
				$this->clearLoginAttempts($request);
			}

			return redirect()->intended('/admin/dashboard');
		} catch (GeneralException $e) {
			// If the login attempt was unsuccessful we will increment the number of attempts
			// to login and redirect the user back to the login form. Of course, when this
			// user surpasses their maximum number of attempts they will get locked out.
			if ($throttles) {
				$this->incrementLoginAttempts($request);

		}
			return redirect()->back()->withInput()->withFlashDanger($e->getMessage());
		}
	}

	/**
	 * @param Request $request
	 * @param $provider
	 * @return mixed
	 */
	public function loginThirdParty(Request $request, $provider) {
		return $this->auth->loginThirdParty($request->all(), $provider);
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function getLogout()
	{


		$this->auth->logout();


		return redirect()->intended('admin/auth/login');
	}

	/**
	 * @param $token
	 * @return mixed
	 * @throws \App\Exceptions\GeneralException
	 */
	public function confirmAccount($token) {
		//Don't know why the exception handler is not catching this
		try {
			$this->auth->confirmAccount($token);
			return redirect()->route('frontend.dashboard')->withFlashSuccess("Your account has been successfully confirmed!");
		} catch (GeneralException $e) {
			return redirect()->back()->withInput()->withFlashDanger($e->getMessage());
		}
	}

	/**
	 * @param $user_id
	 * @return mixed
	 */
	public function resendConfirmationEmail($user_id) {
		//Don't know why the exception handler is not catching this
		try {
			$this->auth->resendConfirmationEmail($user_id);
			return redirect()->route('home')->withFlashSuccess("A new confirmation e-mail has been sent to the address on file.");
		} catch (GeneralException $e) {
			return redirect()->back()->withInput()->withFlashDanger($e->getMessage());
		}
	}

	/**
	 * Helper methods to get laravel's ThrottleLogin class to work with this package
	 */

	/**
	 * Get the path to the login route.
	 *
	 * @return string
	 */
	public function loginPath()
	{
		return property_exists($this, 'loginPath') ? $this->loginPath : '/admin/auth/login';
	}

	/**
	 * Get the login username to be used by the controller.
	 *
	 * @return string
	 */
	public function loginUsername()
	{
		return property_exists($this, 'username') ? $this->username : 'email';
	}

	/**
	 * Determine if the class is using the ThrottlesLogins trait.
	 *
	 * @return bool
	 */
	protected function isUsingThrottlesLoginsTrait()
	{
		return in_array(
			ThrottlesLogins::class, class_uses_recursive(get_class($this))
		);
	}
}