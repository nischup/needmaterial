<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,phone',
        ]);

        $this->sendOtpVerificationCode($request->only('phone'));

        return view('auth.reset-password', $request->only('phone'));
    }

    private function sendOtpVerificationCode($phone)
    {
        $otp = rand(100000, 999999);

        $url = "https://sms.solutionsclan.com/api/sms/send";
        $data = [
            "apiKey"=> "A000362a883636e-a000-4a09-9fd5-39594941d09d",
            "contactNumbers"=> $phone,
            "senderId"=> "8809612440713",
            "textBody"=> "One time Password (OTP) for your auction.com is ".$otp." Enter this code to complete the transaction."
        ];

        $response = Http::post($url, $data);
        if ($response->successful()) {
            Session::put('token', $otp);
        } else {
            logger('Invalid phone verification request');
            logger($response->body());
        }
    }
}
