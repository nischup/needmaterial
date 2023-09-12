@extends('layouts.guest')
@section('title', __('Reset Password'))
@section('breadcrumb')
    {{ Breadcrumbs::render('password.reset') }}
@endsection
@section('content')
    <section class="account-section padding-bottom">
        <div class="container">
            <div class="account-wrapper mt--100 mt-lg--440">
                <div class="left-side">
                    <form class="login-form" method="POST" action="{{ route('password.update') }}">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif


                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
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
                        <div class="form-group">
                            <label for="token"><i class="fas fa-lock"></i></label>
                            <input type="text" class="form-control" name="token" id="token" required autofocus placeholder="{{ __('Verification code') }}" value="{{ old('token') }}">
                        </div>
                        <div class="form-group">
                            <label for="phone"><i class="fas fa-envelope"></i></label>
                            <input type="text" class="form-control" name="phone" id="phone" required autofocus placeholder="{{ __('Phone') }}" value="{{ old('phone', $phone ) }}">
                        </div>

                        <div class="form-group">
                            <label for="password"><i class="fas fa-lock"></i></label>
                            <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password" placeholder="{{ __('New Password') }}">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation"><i class="fas fa-lock"></i></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="custom-button">{{ __('Reset Password') }}</button>
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
