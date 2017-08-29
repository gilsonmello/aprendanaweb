<?php namespace App\Http\Controllers\Frontend\Auth;

use App\Repositories\Frontend\User\UserStudentContract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use App\Http\Requests\Frontend\Access\LoginRequest;
use App\Http\Requests\Frontend\Access\RegisterRequest;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Session;
use App\Enrollment;
use Illuminate\Support\Facades\Input;

/**
 * Class AuthController
 * @package App\Http\Controllers\Frontend\Auth
 */
class AuthController extends Controller {

	use ThrottlesLogins;

	/**
	 * @param AuthenticationContract $auth
	 */
	public function __construct(AuthenticationContract $auth,UserStudentContract $user)
	{
		$this->auth = $auth;
		$this->user = $user;
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function getRegister() {

		return view('frontend.login.index')->withRegister(true);
	}
	
	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postRegisterRetaFinal(){

		if(!Auth::guest() && !user_has_enrollments_in_exam_type('id','=', 125)){
			$date_end = date('Y-m-d');
			$enrollment = new Enrollment;
			$enrollment->student_id = Auth()->user()->id;
			$enrollment->exam_id = 119;
			$enrollment->date_begin = date('Y-m-d H:i:s');
			$enrollment->date_end = date('Y-m-d 23:59:59', strtotime($date_end. ' + 60 days'));
			$enrollment->is_active = 1;
			$enrollment->is_paid = 0;
			if($enrollment->save()){
				return redirect()->route('frontend.dashboard')->withFlashSuccess("Sucesso");
			}
		}else{
			return redirect()->route('frontend.dashboard')->withFlashDanger("Erro");
		}
		
	}

	/**
	 * @param RegisterRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postRegister(RegisterRequest $request)
	{	
		if(config('access.users.confirm_email')) {
			$this->auth->create($request->all());

			return redirect()->route('home')->withFlashSuccess("Sua conta foi criada com sucesso. Um e-mail foi enviado com o procedimento de confirmação.");
		} else {
			//Use native auth login because do not need to check status when registering
			Auth::login($this->auth->create($request->all()));
			if($request->from_cart == 1){
				return redirect()->route('cart.payment');
			}if(strpos(Input::server('HTTP_REFERER'), 'reta-final-essencial-xxi-exame-de-ordem') !== false){
				$date_end = date('Y-m-d');
				$enrollment = new Enrollment;
				$enrollment->student_id = Auth()->user()->id;
				$enrollment->exam_id = 119;
				$enrollment->date_begin = date('Y-m-d H:i:s');
				$enrollment->date_end = date('Y-m-d 23:59:59', strtotime($date_end. ' + 60 days'));
				$enrollment->is_active = 1;
				$enrollment->is_paid = 0;
				if($enrollment->save()){
					return redirect()->route('frontend.exams');
				}
			}else {
				return redirect()->route('frontend.dashboard');
			}
		}
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function getLogin() {
		return view('frontend.login.index')->withRegister(false);
	}

	/**
	 * @param LoginRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postLogin(LoginRequest $request)
	{

		//dd('klajlks');
		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		$throttles = $this->isUsingThrottlesLoginsTrait();


/*        $user = $this->user->getStudentByEmail($request['email']);
        if(md5($request['password']) == $user->password){

            dd('senha correta');

        }
*/
        $user = $this->user->getStudentByEmail($request['email']);
        if($user != null && $user->password == ""){


            $this->validate($request, ['email' => 'required|email']);


            $response = Password::sendResetLink($request->only('email'), function (\Illuminate\Mail\Message $message) {
                $message->subject( app_name() . ': revalide a sua senha no novo portal!');
            });

            if(session('compliance.cart') === TRUE){
            	return redirect()->intended('carrinho/autenticacao')->withInput()->withFlashInfo("Será necessário revalidar sua senha para o novo portal. Um e-mail foi enviado com as instruções.");
            }
			return redirect()->intended('auth/login')->withInput()->withFlashInfo("Será necessário revalidar sua senha para o novo portal. Um e-mail foi enviado com as instruções.");

        }

		if ($throttles && $this->hasTooManyLoginAttempts($request)) {
			return $this->sendLockoutResponse($request);
		}

		//Don't know why the exception handler is not catching this
		try {

			$this->auth->login($request);


            
			//$this->swapUserSession(Auth::user());
			//$this->auth->login($request);
			//Auth::user()->last_session_id = Session::getId();
			//Auth::user()->save();

			if ($throttles) {
				$this->clearLoginAttempts($request);
			}

			$origin = $request['org'];

			$request->session()->put('origin', $origin);


            if($request->from_cart == 1){
                return redirect()->route('cart.payment');
            }else{
                return redirect()->intended('/dashboard');
            }

		} catch (GeneralException $e) {
			

			// If the login attempt was unsuccessful we will increment the number of attempts
			// to login and redirect the user back to the login form. Of course, when this
			// user surpasses their maximum number of attempts they will get locked out.
			if ($throttles) {
				$this->incrementLoginAttempts($request);
			}

			$origin = $request['org'];
			$back = 'auth/login';
			if(session('compliance.cart') === TRUE){
				$back = 'carrinho/autenticacao';
        	}
			if (($origin != null) && ($origin == 'cmpliance')){
				$back = 'auth/login_compliance';
			}
			return redirect()->intended($back)->withInput()->withFlashDanger($e->getMessage());
		}
	}

	/**
	 * @param Request $request
	 * @param $provider
	 * @return mixed
	 */
	public function loginThirdParty(Request $request, $provider) {
		Log::info('log.State');
		Log::info(\Illuminate\Support\Facades\Session::get('state'));
		return $this->auth->loginThirdParty($request->all(), $provider);
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
//	public function getLogout()
//	{
//		$this->auth->logout();
//		return redirect()->intended('auth/login');
//	}
	public function getLogout()
	{

		$this->auth->logout();

		$origin = app('session')->get('origin');
		if (($origin != null) && ($origin == 'compliance')){
			return redirect()->intended('auth/logincompliance');
		}

		return redirect()->route('home');
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
			return redirect()->route('frontend.dashboard')->withFlashSuccess("Your account has been successfully confirmed!
			");
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
		return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
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

	public function swapUserSession()
	{




		$last_session = Session::getHandler()->read(Auth::user()->last_session_id);


		if ($last_session) {
			Session::getHandler()->destroy(Auth::user()->last_session_id);
		}
		//Session::where(serialize($user->id))

		Auth::user()->last_session_id = \Session::getId();
		Auth::user()->save();

		return redirect()->intended('/dashboard');

		//$last_session = Session::getHandler()->read($user->last_session_id); // retrive last session



		//if ($last_session) {
		//	Session::getHandler()->destroy($user->last_session_id);
		//}

	}

	public function endSession(){
		return view('frontend.login.endsession')->render();
	}



	/**
	 * @return \Illuminate\View\View
	 */
	public function getLogincompliance() {
		return view('frontend.login.compliance')->withRegister(false);
	}



}
