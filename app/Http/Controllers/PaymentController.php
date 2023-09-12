<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Omnipay\Omnipay;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public $gateway;
    public $completePaymentUrl;

    public function __construct()
    {
        $this->gateway = Omnipay::create('Stripe\PaymentIntents');
        $this->gateway->setApiKey(env('STRIPE_SECRET_KEY'));
        $this->completePaymentUrl = url('confirm');
    }

    public function charge(Request $request)
    {
        if($request->input('stripeToken'))
        {
            $token = $request->input('stripeToken');

            $response = $this->gateway->authorize([
                'amount' => $request->input('amount'),
                'currency' => env('STRIPE_CURRENCY'),
                'description' => 'This is a wallet recharge transaction.',
                'token' => $token,
                'returnUrl' => $this->completePaymentUrl,
                'confirm' => true,
            ])->send();

            if($response->isSuccessful())
            {
                $response = $this->gateway->capture([
                    'amount' => $request->input('amount'),
                    'currency' => env('STRIPE_CURRENCY'),
                    'paymentIntentReference' => $response->getPaymentIntentReference(),
                ])->send();

                $arr_payment_data = $response->getData();

                $this->store_payment([
                    'payment_id' => $arr_payment_data['id'],
                    'payer_email' => $request->input('email'),
                    'amount' => $arr_payment_data['amount']/100,
                    'currency' => env('STRIPE_CURRENCY'),
                    'payment_status' => $arr_payment_data['status'],
                ]);

                $currentBalance = auth()->user()->balance;
                if (!$currentBalance) {
                    $currentBalance = 0;
                }

                auth()->user()->update([
                    'balance' => $currentBalance + $request->input('amount')
                ]);

                return redirect()->route('frontend.wallet')->with("success", "Payment is successful. Your payment id is: ". $arr_payment_data['id']);
            }
            elseif($response->isRedirect())
            {
                session(['payer_email' => $request->input('email')]);
                $response->redirect();
            }
            else
            {
                return redirect()->route('frontend.wallet')->with("error", $response->getMessage());
            }
        }
    }

    public function confirm(Request $request)
    {
        $response = $this->gateway->confirm([
            'paymentIntentReference' => $request->input('payment_intent'),
            'returnUrl' => $this->completePaymentUrl,
        ])->send();

        if($response->isSuccessful())
        {
            $response = $this->gateway->capture([
                'amount' => $request->input('amount'),
                'currency' => env('STRIPE_CURRENCY'),
                'paymentIntentReference' => $request->input('payment_intent'),
            ])->send();

            $arr_payment_data = $response->getData();

            $this->store_payment([
                'payment_id' => $arr_payment_data['id'],
                'payer_email' => session('payer_email'),
                'amount' => $arr_payment_data['amount']/100,
                'currency' => env('STRIPE_CURRENCY'),
                'payment_status' => $arr_payment_data['status'],
            ]);

            return redirect()->route('frontend.wallet')->with("success", "Payment is successful. Your payment id is: ". $arr_payment_data['id']);
        }
        else
        {
            return redirect()->route('frontend.wallet')->with("error", $response->getMessage());
        }
    }

    public function store_payment($arr_data = [])
    {
        $isPaymentExist = Payment::where('payment_id', $arr_data['payment_id'])->first();

        if(!$isPaymentExist)
        {
            $payment = new Payment;
            $payment->payment_id = $arr_data['payment_id'];
            $payment->payer_email = $arr_data['payer_email'];
            $payment->amount = $arr_data['amount'];
            $payment->currency = env('STRIPE_CURRENCY');
            $payment->payment_status = $arr_data['payment_status'];
            $payment->save();
        }
    }
}
