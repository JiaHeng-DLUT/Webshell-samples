<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request){
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ],[
            'username.required'=>'账号不能为空',
            'password.required' => '请填密码',
            'captcha.required' => '请填写验证码',
            'captcha.captcha' => '验证码错误',
        ]);
    }


   public function authenticated(Request $request, $user)
   {
       if($user->status==0){
           $this->logout($request);
           throw ValidationException::withMessages([
               $this->username() => ['该账号已被禁用,请联系管理员']
           ]);
       }
   }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => ['账号或者密码不对'],
        ]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/login');
    }

    public function username()
    {
        return 'username';
    }
}
