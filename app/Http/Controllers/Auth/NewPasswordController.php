<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'phone' => 'required|exists:users,phone',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->get('token') != Session::get('token')) {
            return redirect()->back()->with('error','Invalid token! Please try again');
        }

        User::where('phone', $request->get('phone'))->update(['password' => bcrypt($request->get('password'))]);

        return redirect()->route('login')->with('success','Password reset successfully  ');
    }
}
