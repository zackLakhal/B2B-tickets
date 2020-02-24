<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Auth;
use App\Clientuser;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Session;
class ClientLoginController extends Controller
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



    /**
     * Create a new partner login controller instance.
     * Call te auth middleware and specify the partner guard.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:client')->except('logout');
    }


    
    public function login(Request $request)
    {
       
        $this->validateReqeust($request);

        
            if(Auth::guard('client')->attempt([ 'email' => $request->email,'password' => $request->password], $request->filled('remember')))
            {   
                $client = Clientuser::where('email','=', $request->email)->first();
                Session::put('client',$client);
                return redirect()->intended(route('client'));
            }
        
        //return redirect()->back()->withInput($request->only('email', 'password'));
        return $this->sendFailedLoginResponse($request);
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    /**
     * Validate the partner's login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function validateReqeust(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    }

   /**
     * Log the partner out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function logout(Request $request)
    {
        Auth::guard('client')->logout();
        Session::forget('client');
        $request->session()->invalidate();
        return redirect()->route('client.login');
    }

    public function logouts(Request $request)
    {
        Auth::guard('client')->logout();
         Session::forget('client');
        $request->session()->invalidate();
        return redirect()->route('client.login');
    }

    // public function redirecTo()
    // {
    //     return '/';
    // }
    public function logoutConnecte(Request $request)
    {
        Auth::guard('client')->logout();
         Session::forget('client');
        $request->session()->invalidate();
        return redirect()->route('client.login');
    }
}
