<?php

namespace App\Http\Livewire;

use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class UserLogin extends Component
{
    public $login, $password, $remember;

    public function render()
    {
        return view('frontend.livewire.login');
    }

    public function mount()
    {
        $this->login = 'supplier@mail.com';
        $this->password = 'password';
    }

    public function authenticate()
    {
        $this->validate([
            'login' => ['required'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Email or Phone number is required'
        ]);

        $this->ensureIsNotRateLimited();

        $user = User::where('email', $this->login)
            ->orWhere('phone', $this->login)
            ->first();

        if (!$user || !$user->is_active || !Hash::check($this->password, $user->password)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }

//        if (!$user->phone_verified_at) {
//            $this->sendVerificationSMS($user->phone);
//
//            return redirect()->route('phone.verify')
//                ->with('phone', $this->login)
//                ->withErrors(['login' => ['We\'ve sent verification code to your phone number. Please verify']]);
//        }

        Auth::login($user, $this->remember);
        RateLimiter::clear($this->throttleKey());

        request()->session()->regenerate();

        activity_log(\auth()->user(), 'signin', __('User Signed In'));

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->login).'|'.request()->ip();
    }

    public function sendVerificationSMS($mobile_number)
    {
        $token = config("services.twilio.token");
        $twilio_sid = config("services.twilio.sid");
        $twilio_verify_sid = config("services.twilio.sid");

        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($mobile_number, "sms");
    }
}
