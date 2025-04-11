<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/movies';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Gunakan 'username' sebagai field login.
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Ambil kredensial login.
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Maksimal percobaan login sebelum lockout.
     */
    public function maxAttempts()
    {
        return 3;
    }

    /**
     * Waktu tunggu dalam menit sebelum bisa login lagi.
     */
    public function decayMinutes()
    {
        return 1;
    }

    /**
     * Handle ketika login dibatasi.
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => __('Too many login attempts. Please try again in :seconds seconds.', [
                    'seconds' => $seconds
                ]),
            ]);
    }

    /**
     * Override fungsi login agar rate limiter bekerja.
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
