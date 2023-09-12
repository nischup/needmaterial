<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class PhoneVerify extends Component
{
    public $phone_number;
    public $verification_code;
    public $resendButtonShow = false;

    public function render()
    {
        return view('frontend.livewire.phone-verify');
    }

    public function mount($phone_number)
    {
        $this->phone_number = $phone_number;
    }

    public function verify()
    {
        $this->validate([
            'verification_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'string'],
        ]);

        if ($this->verification_code == Session::get('OTP')) {
            $user = tap(User::where('phone', $this->phone_number))->update(['phone_verified_at' => now()]);

            Auth::login($user->first());
            return redirect()->route('login')->with(['message' => 'Phone number verified']);
        }

        return back()->with(['error' => 'Invalid verification code entered!']);
    }

    public function resend()
    {
        $otp = rand(100000, 999999);

        $url = "https://sms.solutionsclan.com/api/sms/send";
        $data = [
            "apiKey"=> "A000362a883636e-a000-4a09-9fd5-39594941d09d",
            "contactNumbers"=> $this->phone_number,
            "senderId"=> "8809612440713",
            "textBody"=> "One time Password (OTP) for your Auction.com is ".$otp." Enter this code to complete the transaction."
        ];

        $response = Http::post($url, $data);

        Session::put('OTP', $otp);

        session()->flash('message', __('OTP sent again'));
    }
}
