<?php namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use App\Repositories\Frontend\User\UserContract;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Requests\Frontend\Access\ChangePasswordRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;


/**
 * Class PasswordController
 * @package App\Http\Controllers\Auth
 */
class PasswordController extends Controller {

	use ResetsPasswords;

	/**
	 * @var string
	 */
	protected $redirectPath = "/profile/dashboard";

	/**
	 * @param Guard $auth
	 * @param PasswordBroker $passwords
	 * @param UserContract $user
	 */
	public function __construct(
		Guard $auth,
		PasswordBroker $passwords,
		UserContract $user)
	{
		$this->auth = $auth;
		$this->passwords = $passwords;
		$this->user = $user;
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function getEmail()
	{
		return view('frontend.auth.password');
	}

	/**
	 * Send a reset link to the given user.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postEmail(Request $request)
	{
		$this->validate($request, ['email' => 'required|email']);

		$app = app_name();
		if (($request->only('org') != null) && ($request->only('org') === 'compliance')){
			$app = "ComplianceNet";
		}

		$response = Password::sendResetLink($request->only('email'), function (Message $message) use ($app) {
			$message->subject( $app . ': criar uma nova senha');
		});

		switch ($response) {
			case Password::RESET_LINK_SENT:
				return redirect()->back()->with('status', trans($response));

			case Password::INVALID_USER:
				return redirect()->back()->withErrors(['email' => trans($response)]);
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token))
			throw new NotFoundHttpException;
		return view('frontend.auth.reset')->withToken($token);
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function getChangePassword() {
		return view('frontend.auth.change-password');
	}

	/**
	 * @param ChangePasswordRequest $request
	 * @return mixed
	 */
	public function postChangePassword(ChangePasswordRequest $request) {
		$this->user->changePassword($request->all());
		return redirect()->back()->withFlashSuccess(trans("strings.password_successfully_changed"));
	}
}
