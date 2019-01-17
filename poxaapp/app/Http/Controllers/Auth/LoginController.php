<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout','userLogout']);
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userLogout()
    {
        Auth::guard('web')->logout();

        return redirect('/');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $http_referer = $request->server('HTTP_REFERER');
        $array_referer = explode('/',$http_referer);
        $refer_variable =end($array_referer);
        if($refer_variable == 'login')
        {
//            condition if Login from login page
            return redirect('/login')
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    $this->username() => [trans('auth.failed')],
                ]);


        }else{
//            condition if Login from Header
            return redirect('/')
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    $this->username() => [trans('auth.failed')],
                ]);

        }

    }

}
