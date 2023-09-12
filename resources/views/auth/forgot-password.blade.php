@extends('layouts.guest')
@section('title', __('Forgot Password'))
@section('breadcrumb')
    {{ Breadcrumbs::render('password.request') }}
@endsection
@section('content')
    <section class="account-section padding-bottom">
        <div class="container">
            <div class="account-wrapper mt--100 mt-lg--440">
                <div class="left-side">
                    <div class="section-header">
                        <p>{{ __('Enter your phone number, and we\'ll send a otp code to reset your password') }}</p>
                    </div>
                    <form class="login-form" method="POST" {{ route('password.email') }}>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif


                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <strong>
                                    {!! implode('<br/>', $errors->all('<span>:message</span>')) !!}
                                </strong>
                            </div>
                        @endif
                        @csrf

                        <div class="form-group mb-30">
                            <label for="login-phone"><i class="far fa-envelope"></i></label>
                            <input type="text" name="phone" id="login-phone" placeholder="{{ __('Phone') }}">
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="custom-button">{{ __('Send verification code') }}</button>
                        </div>
                    </form>
                </div>
                <div class="right-side cl-white">
                    <div class="section-header mb-0">
                        <h3 class="title mt-0">{{ __('LOGIN') }}</h3>
                        <a href="{{ route('login') }}" class="custom-button transparent">{{ __('Sign In') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
