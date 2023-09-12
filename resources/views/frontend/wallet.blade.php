@extends('frontend.layouts.master')
@section('title', 'My Wallet')
@section('breadcrumb')
    {{ Breadcrumbs::render('dashboard') }}
@endsection
@section('styles')
    <style>
        .StripeElement {
            box-sizing: border-box;

            height: 40px;

            padding: 10px 12px;

            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;

            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>

    <script src="https://js.stripe.com/v3/"></script>
@endsection
@section('content')
    <!--============= Dashboard Section Starts Here =============-->
    <section class="dashboard-section padding-bottom mt--240 mt-lg--440 pos-rel">
        <div class="container">
            <div class="row justify-content-center">

                @include('frontend.layouts.sidebar')

                <div class="col-lg-8">
                    <div class="dash-bid-item dashboard-widget mb-40-60">
                        <div class="header">
                            <h4 class="title">My Wallet</h4>
                        </div>
                        <h4>Current Balance: ${{ auth()->user()->balance }}</h4>
                            <div class="tab-content">
                                <div class="tab-pane show active fade" id="current">
                                    @if (Session::has('success'))
                                        <div class="alert alert-success text-center">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                            <p>{{ Session::get('success') }}</p>
                                        </div>
                                    @endif

                                    <div id="card-element" class="mt-5 mb-3 form-control" style='height: 2.4em; padding-top: .7em;'>
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>
                                    <div id="card-errors" role="alert" class="alert-danger"></div>
                                    <form action="{{ route('payment.charge') }}" method="post" id="payment-form">
                                        <div class="form-group">
                                            <input type="number" name="amount" class="form-control" placeholder="Enter Amount" />
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control" placeholder="Enter Email" />
                                        </div>

                                        <p><button>Recharge</button></p>
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============= Dashboard Section Ends Here =============-->
@endsection
@section('scripts')
    @livewireScripts

    <script>
        var publishable_key = '{{ env('STRIPE_PUBLISHABLE_KEY') }}';
    </script>
    <script src="{{ asset('/frontend/js/card.js') }}"></script>
@endsection
