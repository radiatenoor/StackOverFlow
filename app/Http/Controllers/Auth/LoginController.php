<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // override
    protected function redirectTo(){
        return '/dashboard';
    }

    // override
    public function showLoginForm(){
        return view('front/auth/login');
        //return view('admin.auth.login') /*Same As*/;
    }


    /**
     * Override
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // login credentials
        // use this when you want to login user by
        // checking email and password field
//        if ($this->attemptLogin($request)) {
//            return $this->sendLoginResponse($request);
//        }
        // when override credentials methods and customised that
        // the below code will not work
        if ($this->guard()->validate($this->credentials($request))){
            $user = $this->guard()->getLastAttempted();
            if ($user->active==1 && $this->guard()->attempt($this->credentials($request))){
                return $this->sendLoginResponse($request);
            }else{
                $this->incrementLoginAttempts($request);
                return redirect('/user/login')
                    ->withErrors(['active'=>'You Are Not Active']);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * override
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/user/login');
    }

    /**
     * Alternate Login Using Different Column
     * Override
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
//    protected function credentials(Request $request)
//    {
//        return [
//            'email'=>$request->email,
//            'password'=>$request->password,
//            'active'=>1
//        ];
//    }
}
