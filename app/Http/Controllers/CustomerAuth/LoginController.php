<?php

namespace App\Http\Controllers\CustomerAuth;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('customer.guest')->except('logout');
    }
    public function showLoginForm()
    {
        return view('customer_auth.login_customer');
    }
   
    public function logout()
    {
        $this->guard()->logout();

        // $request->session()->invalidate();

        return redirect('/');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }
     protected function authenticated()
    {
        return redirect('/');
    }
}
