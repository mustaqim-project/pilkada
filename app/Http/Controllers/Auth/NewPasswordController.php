<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Detection\MobileDetect;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {


        $detect = new MobileDetect();

        if ($detect->isMobile()) {
            return view('mobile.auth.reset-password', ['request' => $request]);
        } elseif ($detect->isTablet()) {
            return view('mobile.auth.reset-password', ['request' => $request]);
        } else {
            return view('auth.reset-password', ['request' => $request]);
        }
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        $detect = new MobileDetect();

        if ($status == Password::PASSWORD_RESET) {
            if ($detect->isMobile() || $detect->isTablet()) {
                return view('mobile.auth.login')->with('status', __($status));
            } else {
                return view('desktop.auth.login')->with('status', __($status));
            }
        } else {
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => __($status)]);
        }
    }

}
