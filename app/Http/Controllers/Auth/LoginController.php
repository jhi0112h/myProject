<?php

namespace App\Http\Controllers\Auth;

use App\Components\User\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $token = $this->guard()->attempt($this->credentials($request));

        if ($token) {
            $this->guard()->setToken($token);

            return true;
        }

        return false;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        $token = (string) $this->guard()->getToken();
        $expiration = $this->guard()->getPayload()->get('exp');

        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration - time(),
        ];
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @return
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $error = array();
        if ( ! User::where('email', $request->email)->first() ) {
            $error += ['email' => Lang::get('auth.email')];
            return $error;
        }

        if ( ! User::where('email', $request->email)->where('password', bcrypt($request->password))->first() ) {
            $error += ['password' => Lang::get('auth.password')];
        }

        return response()->json($error);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
    }
}
