<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{
    private $errors=[];
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
        $this->middleware('guest')
            ->except('logout','profile','profileUpdate','changePassword');
    }

    // override
    protected function redirectTo(){
        return '/dashboard';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
        $auth=Auth::guard()->attempt($this->credentials($request));
        if ($auth){
            // it will work after the login successful
            $user = Auth::guard()->getLastAttempted()/*get recent loged in user data*/;
            $active=false;
            $title =false;
            /*Activation Check*/
            if ($user->active==1){
                $active=true;
            }else{
                $this->incrementLoginAttempts($request);
                $this->errors['active']= "Not Active";

            }
            // title check
//            if ($user->title=="Software Developer"){
//                $title=true;
//            }else{
//                $this->incrementLoginAttempts($request);
//                $this->errors['title']= "You Are Not Software Developer";
//
//            }
            /*Extra more field to check */

            /* final response. where it redirect to dashboard or home route*/
            if ($active /* && $title more true check*/){
                return $this->sendLoginResponse($request);
            }else{
                $this->destroyLogged($request);
            }

            return redirect('/user/login')
                ->withInput($request->only('email'))
                ->withErrors($this->errors);
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    public function destroyLogged(Request $request){
        $this->guard()->logout();

        $request->session()->invalidate();

        $this->loggedOut($request);
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
//            'password'=>$request->password
//        ];
//    }

      public function profile(){

          return view('front.profile.profile');
      }


      public function profileUpdate(Request $request){
          $this->validate($request,[
              'name'=>'required|min:6',
              'email'=>'required|email|unique:users,email,'.Auth::id(),
              'title'=>'required',
              'location'=>'required'
          ]);

          $user = User::find(Auth::id());
          $user->name = $request->name;
          $user->email = $request->email;
          $user->title = $request->title;
          $user->location = $request->location;
          if ($request->hasFile('photo')){
              $image = $request->file('photo');
              $filename = time().".".$image->getClientOriginalExtension();
              $path = public_path('images');
              $image->move($path,$filename);
              $user->photo = $filename;
          }
          $user->save();
          Session::flash('success','You Have Successfully Updated');
          return redirect()->back();
      }

      public function changePassword(Request $request){
          $this->validate($request,[
              'password'=>'required|confirmed|min:6'
          ]);

          $user = User::find(Auth::id());
          $user->password = bcrypt($request->password);
          $user->save();

          Session::flash('success','You Have Successfully Changed The Password');
          return redirect()->back();
      }
}
