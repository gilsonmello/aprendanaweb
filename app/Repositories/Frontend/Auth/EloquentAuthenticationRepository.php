<?php

namespace App\Repositories\Frontend\Auth;

use App\User;
use App\Exceptions\GeneralException;
use App\Repositories\Frontend\User\UserContract;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Laravel\Socialite\Contracts\Factory as Socialite;
use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Auth\UserLoggedOut;
use Session;
use App\Enrollment;

/**
 * Class Registrar
 * @package App\Services
 */
class EloquentAuthenticationRepository implements AuthenticationContract
{

    /**
     * @var Socialite
     */
    private $socialite;

    /**
     * @var Guard
     */
    private $auth;

    /**
     * @var UserContract
     */
    private $users;

    /**
     * @param Socialite $socialite
     * @param Guard $auth
     * @param UserContract $users
     */
    public function __construct(Socialite $socialite, Guard $auth, UserContract $users)
    {
        $this->socialite = $socialite;
        $this->users = $users;
        $this->auth = $auth;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    public function create(array $data)
    {
        return $this->users->create($data);
    }

    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws GeneralException
     */
    public function login($request)
    {
        if ($this->auth->attempt($request->only('email', 'password'), $request->has('remember'))) {
            if ($this->auth->user()->status == 0) {
                $this->auth->logout();
                throw new GeneralException("Sua conta está desativada");
            }

            if ($this->auth->user()->status == 2) {
                $this->auth->logout();
                throw new GeneralException("Sua conta foi banida.");
            }

            if ($this->auth->user()->confirmed == 0) {
                $user_id = $this->auth->user()->id;
                $this->auth->logout();
                throw new GeneralException("Sua conta não está verificada. Por favor, verifique o link de verifação no seu e-mail ou " . '<a href="' . route('account.confirm.resend', $user_id) . '">clique aqui</a>' . " para re-enviar o e-mail.");
            }

            if (!$this->auth->user()->is("Aluno")) {
                $this->auth->logout();
                throw new GeneralException("Sua conta não é uma conta de aluno");
            }

            event(new UserLoggedIn($this->auth->user()));
            return true;
        }

        throw new GeneralException('Usuário inexistente ou senha incorreta.');
    }

    /**
     * Log the user out and fire an event
     */
    public function logout()
    {
        event(new UserLoggedOut($this->auth->user()));
        $this->auth->logout();
    }

    /**
     * Socialite Functions
     * @param $request
     * @param $provider
     * @return bool|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginThirdParty($request, $provider)
    {

        if (strpos(Request::server('HTTP_REFERER'), 'reta-final-essencial-xxi-exame-de-ordem') !== false) {
            Session::push('referer', 'reta-final-essencial-xxi-exame-de-ordem');
        } else if (strpos(Request::server('HTTP_REFERER'), 'carrinho') !== false) {
            Session::push('referer', 'carrinho');
        }

        if (!$request) {
            return $this->getAuthorizationFirst($provider);
        }

        $socialUser = $this->getSocialUser($provider);

        if ($socialUser->getEmail() == null || $socialUser->getEmail() == "") {
            return redirect()->intended('auth/login')->withInput()->withFlashInfo("É necessário confirmar o e-mail do facebook para prosseguir. Faça isso nas configurações de sua conta do facebook.");
        }

        $user = $this->users->findByUserNameOrCreate($socialUser, $provider);

        $this->auth->login($user, true);

        event(new UserLoggedIn($user));

        Log::info('log.from_cart');

        if (Session::get('referer')[0] == 'carrinho') {
            Session::forget('referer');
            return redirect()->route('cart.payment');
        } else if (Session::get('referer')[0] == 'reta-final-essencial-xxi-exame-de-ordem') {
            $date_end = date('Y-m-d');
            $enrollment = new Enrollment;
            $enrollment->student_id = Auth()->user()->id;
            $enrollment->exam_id = 119;
            $enrollment->date_begin = date('Y-m-d H:i:s');
            $enrollment->date_end = date('Y-m-d 23:59:59', strtotime($date_end . ' + 60 days'));
            $enrollment->is_active = 1;
            $enrollment->is_paid = 0;
            if ($enrollment->save()) {
                Session::forget('referer');
                return redirect()->route('frontend.dashboard');
            }
        } else {
            Session::forget('referer');
            return redirect()->route('frontend.dashboard');
        }
    }

    /**
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getAuthorizationFirst($provider)
    {
        if ($provider == "google") {
            /*
             * Only allows google to grab email address
             * Default scopes array also has: 'https://www.googleapis.com/auth/plus.login'
             * https://medium.com/@njovin/fixing-laravel-socialite-s-google-permissions-2b0ef8c18205
             */
            $scopes = [
                'https://www.googleapis.com/auth/plus.me',
                'https://www.googleapis.com/auth/plus.profile.emails.read',
            ];
            return $this->socialite->driver($provider)->scopes($scopes)->redirect();
        }
        return $this->socialite->driver($provider)->redirect();
    }

    /**
     * @param $provider
     * @return \Laravel\Socialite\Contracts\User
     */
    public function getSocialUser($provider)
    {
        return $this->socialite->driver($provider)->user();
    }

    /**
     * @param $token
     * @return mixed
     */
    public function confirmAccount($token)
    {
        return $this->users->confirmAccount($token);
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function resendConfirmationEmail($user_id)
    {
        return $this->users->sendConfirmationEmail($user_id);
    }

    protected function swapUserSession($user)
    {

        //Session::where(serialize($user->id))

        $new_session_id = Session::getId(); //get new session_id after user sign in
        $last_session = Session::getHandler()->read($user->last_session_id); // retrive last session


        if ($last_session) {
            Session::getHandler()->destroy($user->last_session_id);
        }

        $user->last_session_id = $new_session_id;


        $user->save();
    }

}
